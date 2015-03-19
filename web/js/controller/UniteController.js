/**
 * Created by delphinsagno on 15/03/15.
 */
app.controller('UniteController',['$scope','Restangular','$rootScope','uniteFactory','$timeout',
    function($scope,Restangular,$rootScope,uniteFactory,$timeout){
        $rootScope.afficheMessage=false;
        $rootScope.loading=true;
        console.log("1"+$rootScope.loading);
        $timeout(function(){
            uniteFactory.getList().then(function(unites){
                $scope.unites = unites;
                $rootScope.$broadcast("onLoading");
            });
        },2000)

        $scope.newUnite = {};
        $scope.saveUnite = function(){
            unites.post($scope.newUnite).then(function(u){
                $scope.unites.push($scope.newUnite);
                $scope.newUnite = {};
            },function(msg){
                $rootScope.afficheMessage=true;
                $rootScope.message=msg.statusText;
            });
        };

        $scope.editUnite = function(unite){
            $scope.newUnite = unite;
        };

        $scope.deleteUnite = function(unite){

        }
}]);