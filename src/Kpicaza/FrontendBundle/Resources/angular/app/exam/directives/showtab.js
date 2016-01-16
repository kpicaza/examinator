function showtab() {
    return {
        link: function (scope, element, attrs) {
            element.click(function (e) {
                e.preventDefault();
                $(element).tab('show');
            });
        }
    };

}

angular.module('frontendApp.exam').directive('showtab', showtab);