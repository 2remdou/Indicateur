/**
 * Created by delphinsagno on 15/03/15.
 */
app.controller('UniteController',['$scope','Restangular','$rootScope','uniteFactory',
    function($scope,Restangular,$rootScope,uniteFactory){
        $rootScope.loading=true;
            uniteFactory.getList().then(function(unites){
                $scope.unites = unites;
                $rootScope.loading=false;
                $rootScope.message={
                    message:"Enregistrement effectué",
                    typealert:"info"
                };
                $rootScope.$broadcast('onShowMessage');
            });

        $scope.newUnite = {};
        $scope.saveUnite = function(){
            uniteFactory.post($scope.newUnite).then(function(u){
                $scope.unites.push($scope.newUnite);
                $scope.newUnite = {};
            });
        };

        $scope.editUnite = function(unite){
            $scope.newUnite = unite;
        };

        $scope.deleteUnite = function(unite){

        }
}]);