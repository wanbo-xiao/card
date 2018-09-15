app.controller('twitterController', function ($scope, $http) {
    $scope.twitters = [];
    $http({
        url: "twitter/searchTwitter",
        method: "GET",
        params: {}
    }).then(function (response) {
        $scope.twitters = response.data
    });
});
