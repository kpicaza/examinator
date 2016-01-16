'use strict';

angular.module('frontendApp.question', [
    'ngRoute',
    'questionServices'
]).
        config(['$routeProvider',
            function ($routeProvider) {
                $routeProvider.
                        when('questions/:id', {
                            templateUrl: '/../bundles/kpicazafrontend/app/exam/views/show-detail.html',
                            controller: 'QuestionDetailCtrl'
                        })
                        ;
            }
        ]).
        controller('QuestionDetailCtrl', ['$scope', '$routeParams', 'Question', function ($scope, $routeParams, Exam) {
                $scope.question = Question.get({id: $routeParams.id});
            }
        ])

        ;