<?php


namespace App\Manager;

use Certificationy\Loaders\YamlLoader;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class DataManager
{
    const NAME_QUESTIONS = 'questions';
    /**
     * @var string[]
     */
    protected $sources;
    /**
     * @var bool
     */
    protected $loaded = false;
    /**
     * @var string[]
     */
    private $packs = [];

    /**
     * @var array
     */
    private $categories = [];

    /**
     * @var SessionInterface
     */
    private $session;

    public function __construct(array $sources, SessionInterface $session)
    {
        $this->sources = $sources;
        $this->session = $session;
    }

    public function getInitialData()
    {
        return [
            'packs' => $this->getPacks(),
            'categories' => $this->getCategories()
        ];
    }

    /**
     * @return string[]
     */
    public function getPacks(): array
    {
        $this->load();
        return $this->packs;
    }

    public function load()
    {
        if (!$this->loaded) {
            foreach ($this->sources as $source) {
                $packName = basename(dirname($source));
                $loader = new YamlLoader([$source]);
                $categories = $loader->categories();

                $this->packs[$packName] = [];
                foreach ($categories as $category) {
                    $categoryData = [
                        'id' => $packName . ':' . $category,
                        'pack' => $packName,
                        'name' => $category,
                    ];
                    $this->packs[$packName][] = $categoryData;
                }
            }
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getCategories(): array
    {
        $this->load();
        return $this->categories;
    }

    public function getQuestions(int $nbQuestions, array $selectedCategories)
    {
        $result = [];
        foreach ($this->sources as $source) {
            $packName = basename(dirname($source));

            $categories = [];
            foreach ($selectedCategories as $selectedCategory) {
                if ($selectedCategory['pack'] === $packName) {
                    $categories[] = $selectedCategory['name'];
                }
            }
            if ($categories) {
                $loader = new YamlLoader([$source]);
                $questions = $loader->load($nbQuestions, $categories);
                if ($questions->count()) {
                    $serializer = new Serializer([new ObjectNormalizer()]);
                    $data = $serializer->normalize(array_values($questions->all()));

                    $result = array_merge($result, $data);
                }
            }
        }
        shuffle($result);
        $result = array_slice($result, 0, $nbQuestions);

        $this->session->set(self::NAME_QUESTIONS, $result);

        foreach ($result as &$question) {
            unset($question['correctAnswersValues']);
        }

        return $result;
    }

    public function getResult(array $userAnswers)
    {
        $result = [
            'rightCount' => 0,
            'totalCount' => 0,
            'questions' => []
        ];
        if ($this->session->has(self::NAME_QUESTIONS)) {
            $questions = $this->session->get(self::NAME_QUESTIONS);
            foreach ($questions as $index => &$question) {
                $correct = false;
                $result['totalCount']++;
                $correctAnswersValues = $question['correctAnswersValues'];
                $questionUserAnswers = isset($userAnswers[$index]) ? $userAnswers[$index] : [];
                if (is_scalar($questionUserAnswers)) {
                    $questionUserAnswers = [$questionUserAnswers];
                }
                if (is_array($correctAnswersValues)
                    && is_array($questionUserAnswers)
                    && count($correctAnswersValues) == count($questionUserAnswers)
                    && array_diff($correctAnswersValues, $questionUserAnswers)
                    === array_diff($questionUserAnswers, $correctAnswersValues)
                ) {
                    $correct = true;
                    $result['rightCount']++;
                }

                $question['correct'] = $correct;
                $question['userAnswers'] = $questionUserAnswers;

                foreach ($question['answers'] as &$data) {
                    $data['user'] = null;
                    if (in_array($data['value'], $questionUserAnswers, true)) {
                        $data['user'] = $data['correct'];
                    }
                }
            }

            $result['questions'] = $questions;
        } else {
            throw new \RuntimeException('You should run getQuestions first');
        }

        return $result;
    }
}
