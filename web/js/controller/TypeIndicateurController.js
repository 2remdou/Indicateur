/**
 * Created by Toure on 21/03/15.
 */
app.controller('TypeIndicateurController',['$scope','Restangular','$rootScope','typeIndicateurFactory',
    function($scope,Restangular,$rootScope,typeIndicateurFactory){
        intercepErrot(Restangular,$rootScope);
        $rootScope.loading=true;
        typeIndicateurFactory.getList().then(function(typeIndicateurs){
            $scope.typeIndicateurs = typeIndicateurs;
            $rootScope.loading=false;
            //$rootScope.$broadcast('onShowMessage');
        });

        $scope.newTypeIndicateur = {};
        $scope.saveTypeIndicateur = function(){
            if($scope.method === "PUT"){
                $scope.newTypeIndicateur.put({id:$scope.newTypeIndicateur.id}).then(function(typeInd){
                    console.log(typeInd);
                    $scope.newTypeIndicateur = {};
                    $rootScope.$broadcast('showMessage',
                        {messages:["Modification effectuée"],
                            typeAlert:"success"
                        }) ;
                });
                $scope.method = "POST";
            }
            else{
                typeIndicateurFactory.post($scope.newTypeIndicateur).then(function(u){
                    $scope.typeIndicateurs.push($scope.newTypeIndicateur);
                    $scope.newTypeIndicateur = {};
                    $rootScope.$broadcast('showMessage',{
                        messages:["Enregistrement effectué"],
                        typeAlert:"success"
                    });
                });
            }

        };

        $scope.editTypeIndicateur = function(typeIndicateur){
            $scope.newTypeIndicateur = typeIndicateur;
            $scope.method = "PUT"
        };

        $scope.deleteTypeIndicateur = function(typeIndicateur){
            $scope.typeIndicateur=typeIndicateur;
            typeIndicateur.remove().then(function(u){
                $rootScope.$broadcast('showMessage',{
                    messages:["Suppression effectuée"],
                    typeAlert:"success"
                });
                var index = $scope.typeIndicateurs.indexOf(typeIndicateur);
                $scope.typeIndicateurs.splice(index,1);
            });
        }
    }]);