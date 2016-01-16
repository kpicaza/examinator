'use strict';

// Declare app level module which depends on views, and components
angular.module('frontendApp', [
    'ngRoute',
    'frontendApp.exam'
]).
        config(['$routeProvider', function ($routeProvider) {
                $routeProvider
                        .otherwise({
                            redirectTo: '/exams'
                        });
            }
        ]);