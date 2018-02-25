import axios from 'axios';

export default {
    getQuestions(request) {
        axios.post('/api/questions', request)
            .then(function (response) {
                // console.log(response);
            })
            .catch(function (error) {
                // console.log(error);
            });
    }
}
