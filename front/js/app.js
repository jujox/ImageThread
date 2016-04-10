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

function MainController($scope, $http, $window) {
    $scope.posts = 0;
    $scope.views = 0;
    $scope.imageFile = "";
    $scope.title = "";
    $scope.image_status = "";

    $scope.addView = function() {
        $http({
            method  : 'POST',
            url     : 'http://localhost/ImageThread/index.php/view',
        });
    }

    $scope.getImages = function () {
        $http({
            method  : 'GET',
            url     : 'http://localhost/ImageThread/index.php/list',
        })
        .success(function(data) {
            $scope.listImages = data;
            $scope.posts = data.length;
        });
    }

    $scope.getViews = function () {
        $http({
            method  : 'GET',
            url     : 'http://localhost/ImageThread/index.php/view',
        })
        .success(function(data) {
            $scope.views = data[0].numviews;
        });
    }

    $scope.upload = function () {
        var formData = new FormData();
        var file = $scope.imageFile;
        formData.append('title', $scope.title);
        formData.append('imageFile', file);
        var url = 'http://localhost/ImageThread/index.php/save';

        $scope.image_status = "Uploading image... Wait a moment...";
        $http.post(url, formData, {
            headers: {
                  'Content-Type': undefined
               },
        })
        .success(function(data) {
            console.log(data);
            if (data.status != "OK") {
                $scope.image_status = "Error uploading image: " + data.data;
            } else {
                $scope.image_status = "Image uploaded... Thank you!";
                $scope.getImages();
            }
        })
        .error(function (data) {
            $scope.image_status = "Error uploading image";
        });

        console.log("Uploading...");
    }

    $scope.addView();
    $scope.getViews();
    $scope.getImages();
    $scope.export = function() {
        $window.open("http://localhost/ImageThread/index.php/export");
    }
}
