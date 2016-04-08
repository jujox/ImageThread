angular.module('myApp', ['ngRoute']).
    config(['$routeProvider', function ($routeProvider) {
        $routeProvider.
            when('/', {
                templateUrl: 'index.html.tpl',
                controller: MainController
            }).
            otherwise({redirectTo: '/'});
}])
.directive('fileModel', ['$parse', function ($parse) {
    return {
        restrict: 'A',
        link: function(scope, element, attrs) {
            var model = $parse(attrs.fileModel);
            var modelSetter = model.assign;
            
            element.bind('change', function(){
                scope.$apply(function(){
                    modelSetter(scope, element[0].files[0]);
                });
            });
        }
    };
}]);

function MainController($scope, $http) {
    $scope.posts = 0;
    $scope.views = 0;
    $scope.imageFile = "";
    $scope.title = "";

    $http({
        method  : 'GET',
        url     : 'http://localhost/ImageThread/index.php/list',
    })
    .success(function(data) {
        $scope.listImages = data;
        $scope.posts = data.length;
    });

    $scope.upload = function () {
        var formData = new FormData();
        var file = $scope.imageFile;
        formData.append('title', $scope.title);
        formData.append('imageFile', file);
        var url = 'http://localhost/ImageThread/index.php/save';

        $http.post(url, formData, {
            headers: {
                  'Content-Type': undefined
               },
        })
        .success(function(data) {
            console.log("Uploaded...");
        });

        console.log("Uploading...");
    }
}
