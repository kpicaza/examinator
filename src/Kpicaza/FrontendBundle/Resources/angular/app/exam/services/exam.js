'use strict';

/* Services */
var examServices = angular.module('examServices', ['ngResource']);

examServices.factory('Exam', ['$resource',
    function ($resource) {
        return $resource('api/examso/:id', {}, {
            query: {
                method: 'GET', 
                params: {
                    id: null, 
                    keywords: null,
                    limit: null,
                    offset: null
                },
                isArray: true
            }
        });
    }
]);
