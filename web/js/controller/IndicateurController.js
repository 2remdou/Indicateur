/**
 * Created by delphinsagno on 15/03/15.
 */
app.controller('IndicateurController',['$scope','Restangular','$rootScope','indicateurFactory','typeIndicateurFactory',
    function($scope,Restangular,$rootScope,indicateurFactory,typeIndicateurFactory){
        intercepErrot(Restangular,$rootScope);
        $rootScope.loading=true;
            indicateurFactory.getList().then(function(indicateurs){
                $scope.indicateurs = indicateurs;
                $rootScope.loading=false;
                //$rootScope.$broadcast('onShowMessage');
            });
        typeIndicateurFactory.getList().then(function(typeIn){
            $scope.typeIndicateurs = typeIn;
        });

        $scope.newIndicateur = {};
        $scope.saveIndicateur = function(){
            if($scope.method === "PUT"){
                $scope.newIndicateur.put({id:$scope.newIndicateur.id}).then(function(u){
                    $scope.newIndicateur = {};
                    $rootScope.$broadcast('showMessage',
                        {messages:["Modification effectuée"],
                            typeAlert:"success"
                    }) ;
                });
                $scope.method = "POST";
            }
            else{
                //Restangular.one(getRoute('post_indicateur'),$scope.newIndicateur.typeIndicateur.id).post()
                indicateurFactory.post($scope.newIndicateur,{typeIndicateur:$scope.newIndicateur.typeIndicateur.id})
                    .then(function(u){
                    $scope.indicateurs.push($scope.newIndicateur);
                    $scope.newIndicateur = {};
                    $rootScope.$broadcast('showMessage',{
                        messages:["Enregistrement effectué"],
                        typeAlert:"success"
                    });
                });
            }

        };

        $scope.editIndicateur = function(indicateur){
            $scope.newIndicateur = indicateur;
            $scope.method = "PUT"
        };

        $scope.deleteIndicateur = function(indicateur){
            $scope.indicateur=indicateur;
            indicateur.remove().then(function(u){
                $rootScope.$broadcast('showMessage',{
                    messages:["Suppression effectuée"],
                    typeAlert:"success"
                });
                var index = $scope.indicateurs.indexOf(indicateur);
                $scope.indicateurs.splice(index,1);
            });
        }
}]);