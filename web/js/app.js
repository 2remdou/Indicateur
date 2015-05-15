/**
 * Created by delphinsagno on 15/03/15.
 */

var app = angular.module('app',[
    'restangular',
    'ngRoute',
    'checklist-model'
]);

app.config(['$routeProvider',function($routeProvider){
   $routeProvider
       .when('/unites',{
           templateUrl: 'js/view/unite.html',
           controller: 'UniteController'
       })
       .when('/hotes',{
           templateUrl: 'js/view/hote.html',
           controller: 'HoteController'
       })
       .when('/type-indicateurs',{
           templateUrl : 'js/view/typeIndicateur.html',
           controller: 'TypeIndicateurController'
       })
       .when('/indicateurs',{
           templateUrl : 'js/view/indicateur.html',
           controller: 'IndicateurController'
       })
       .when('/detail-indicateurs',{
           templateUrl : 'js/view/detailIndicateur.html',
           controller: 'DetailIndicateurController'
       })
       .otherwise({redirectTo:'/'});
}]);

app.config(function(RestangularProvider){
    RestangularProvider.setBaseUrl(getBaseUrl());
    RestangularProvider.setRequestSuffix('.json');

});

var getRoute = function(routeName,parametres){

    return Routing.generate(routeName,parametres,false).slice(1);
}
function intercepError(Restangular,$rootScope){
    Restangular.setErrorInterceptor(function(response, deferred, responseHandler){
        var m = [];
        if(response.data){
            angular.forEach(response.data.errors,function(value){
                m.push(value.message);
            });
            $rootScope.$broadcast('showMessage',{
                messages : m,
                typeAlert: "danger"
            })
        }
    });
}
