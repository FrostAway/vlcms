(function ($) {

    angular.module('ngMusic', [
        'ui.router',
        'musicService',
        'musicController'
    ], function ($interpolateProvider) {
        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>');
    }).run(function ($state, $rootScope) {
        $state.go('music');
    }).config(function ($stateProvider, $urlRouterProvider, $locationProvider) {
        var _viewUrl = '/views/music/';
        
        $stateProvider.state('music', {
            url: _URL,
            templateUrl: _viewUrl + 'folder.html',
            controller: 'oneDriveController'
        }).state('folder', {
            url: _URL + '/folder/:id',
            templateUrl: _viewUrl + 'folder.html',
            controller: 'folderController'
        });

        $urlRouterProvider.otherwise(_URL);
        $locationProvider.html5Mode({
            enabled: true,
            requireBase: false
        });
        $locationProvider.hashPrefix('!');
    });

})();


