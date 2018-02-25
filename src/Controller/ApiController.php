<?php


namespace App\Controller;

use App\Manager\DataManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends Controller
{
    /**
     * @Route(path="/api/questions")
     * @param Request $request
     * @return JsonResponse
     */
    public function getQuestions(Request $request)
    {
        $response = new JsonResponse();

        try {
            $requestData = json_decode($request->getContent(), true);
            $response->setData([
                'request_data' => $requestData,
                'questions' => $this->get(DataManager::class)
                    ->getQuestions($requestData['questionCount'], $requestData['selectedCategories'])
            ]);
        } catch (\Exception $exception) {
            $response->setData(['error' => $exception->getMessage()]);
        }

        return $response;
    }

    /**
     * @Route(path="/api/results")
     * @param Request $request
     * @return JsonResponse
     */
    public function getResults(Request $request)
    {
        $response = new JsonResponse();

        try {
            $requestData = json_decode($request->getContent(), true);
            $response->setData(
                $this->get(DataManager::class)
                    ->getResult($requestData['userAnswers'] ?? [])
            );
        } catch (\Exception $exception) {
            $response->setData(['error' => $exception->getMessage()]);
        }

        return $response;
    }
}
