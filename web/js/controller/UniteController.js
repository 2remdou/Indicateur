/**
 * Created by delphinsagno on 15/03/15.
 */
app.controller('UniteController',['$scope','Restangular','$rootScope','uniteFactory',
    function($scope,Restangular,$rootScope,uniteFactory){
        $rootScope.afficheMessage=false;
        $scope.unites = uniteFactory.all();
        console.log($scope.unites);
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