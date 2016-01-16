'use strict';

/* Services */
var questionServices = angular.module('questionServices', ['ngResource']);

questionServices.factory('Question', ['$resource',
    function ($resource) {
        return $resource('api/questions/:id', {}, {
            query: {method: 'GET', params: {id: null, exam_id: null}, isArray: true}
        });
    }
]);
