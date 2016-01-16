function appAjaxGet() {
    return {
        restrict: 'E',
        controller: function ($scope, $http, $attrs) {

            $http.get(
                    $attrs.path,
                    {
                        params: {
                            id: !$attrs.sourceId ? null : $attrs.sourceId,
                            keywords: null,
                            limit: $attrs.limit ? $attrs.limit : 9,
                            offset: $attrs.offset ? $attrs.offset : 0
                        },
                        isArray: true
                    }
            ).success(function (data) {
                $scope.data = data;
            }).error(function (data) {
                
            });
        }
    };
}

angular.module('frontendApp.exam').directive('appAjaxGet', appAjaxGet);