'use strict';

angular.module('frontendApp.exam', [
    'ngRoute',
    'examServices'
])

        .config(['$routeProvider',
            function ($routeProvider) {
                $routeProvider.
                        when('/exams', {
                            templateUrl: '/../bundles/kpicazafrontend/app/exam/views/index.html',
                            controller: 'ExamCtrl'
                        }).
                        when('/exams/:id/take', {
                            templateUrl: '/../bundles/kpicazafrontend/app/exam/views/complete-exam.html',
                            controller: 'ExamTakeCtrl'
                        }).
                        when('/exams/:id', {
                            templateUrl: '/../bundles/kpicazafrontend/app/exam/views/show-detail.html',
                            controller: 'ExamDetailCtrl'
                        })
                        ;
            }])

        .controller('ExamCtrl', ['$scope', '$http', 'Exam', function ($scope, $http, Exam) {
                $scope.exams = Exam.query();

                $scope.keywords = '';

                $scope.search = function () {
                    $scope.exams = Exam.query({keywords: $scope.keywords});

                };
            }
        ])

        .controller('ExamDetailCtrl', ['$scope', '$routeParams', 'Exam', function ($scope, $routeParams, Exam) {
                $scope.exam = Exam.get({id: $routeParams.id});

            }
        ])

        .controller('ExamTakeCtrl', ['$scope', '$routeParams', 'Exam', function ($scope, $routeParams, Exam) {
                $scope.exam = Exam.get({id: $routeParams.id});

                $scope.master = {};
                $scope.examModel = {
                    exam_id: $scope.exam.id,
                    responses: {}
                };

                $scope.update = function (examModel) {
                    $scope.master = angular.copy(examModel);
                };

                $scope.reset = function (form) {
                    if (form) {
                        form.$setPristine();
                        form.$setUntouched();
                    }
                    $scope.examModel = angular.copy($scope.master);
                };

                $scope.reset();
            }])
        ;