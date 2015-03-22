/**
 * Created by delphinsagno on 15/03/15.
 */

var app = angular.module('app',[
    'restangular',
    'ngRoute'
]);

app.config(['$routeProvider',function($routeProvider){
   $routeProvider
       .when('/unites',{
           templateUrl: 'js/view/unite.html',
           controller: 'UniteController'
       })
       .when('/type-indicateurs',{
           templateUrl : 'js/view/typeIndicateur.html',
           controller: 'TypeIndicateurController'
       })
       .when('/indicateurs',{
           templateUrl : 'js/view/indicateur.html',
           controller: 'IndicateurController'
       })
       .otherwise({redirectTo:'/'});
}]);

app.config(function(RestangularProvider){
    RestangularProvider.setBaseUrl(getBaseUrl());
    RestangularProvider.setRequestSuffix('.json');

});

/*
app.config(['$rootScope',function($rootScope){
    $rootScope.showMessage = false;
}]);
*/

var getRoute = function(routeName,parametres){

    return Routing.generate(routeName,{},false).slice(1);
}
function intercepErrot(Restangular,$rootScope){
    Restangular.setErrorInterceptor(function(response, deferred, responseHandler){
        var m = [];
        angular.forEach(response.data.errors,function(value){
            m.push(value.message);
        });
        $rootScope.$broadcast('showMessage',{
            messages : m,
            typeAlert: "danger"
        })
    });
}
