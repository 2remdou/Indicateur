/**
 * Created by delphinsagno on 15/03/15.
 */
app.controller('HoteController',['$scope','Restangular','$rootScope','hoteFactory',
    function($scope,Restangular,$rootScope,hoteFactory){
        intercepError(Restangular,$rootScope);
        $rootScope.$broadcast('hideMessage') ;
        $rootScope.loading=true;
            hoteFactory.getList().then(function(hotes){
                $scope.hotes = hotes;
                if(hotes.length===0){
                    $rootScope.$broadcast('showMessage',
                        {messages:["Aucun hote pour le moment"],
                            typeAlert:"info"
                        }) ;
                }
                $rootScope.loading=false;
                //$rootScope.$broadcast('onShowMessage');
            });

        $scope.newHote = {};
        $scope.saveHote = function(){
            if(!controlFields()) return;
            if($scope.method === "PUT"){
                $scope.newHote.put({id:$scope.newHote.id}).then(function(u){
                    $scope.newHote = {};
                    $rootScope.$broadcast('showMessage',
                        {messages:["Modification effectuée"],
                            typeAlert:"success"
                    }) ;
                });
                $scope.method = "POST";
            }
            else{
                hoteFactory.post($scope.newHote).then(function(u){
                    $scope.hotes.push($scope.newHote);
                    $scope.newHote = {};
                    $rootScope.$broadcast('showMessage',{
                        messages:["Enregistrement effectué"],
                        typeAlert:"success"
                    });
                });
            }

        };

        $scope.editHote = function(hote){
            $scope.newHote = hote;
            $scope.method = "PUT"
        };

        $scope.deleteHote = function(hote){
            $scope.hote=hote;
            hote.remove().then(function(u){
                $rootScope.$broadcast('showMessage',{
                    messages:["Suppression effectuée"],
                    typeAlert:"success"
                });
                var index = $scope.hotes.indexOf(hote);
                $scope.hotes.splice(index,1);
            });
        }
        $scope.annuler = function(){
            $scope.method = "POST";
            $scope.newHote={};
        }

        function controlFields(){
            if(!$scope.newHote.adresseHote){
                $rootScope.$broadcast('showMessage',{
                    messages:["Veuillez fournir l'adresse de l'hote"],
                    typeAlert:"danger"
                });
                return false;
            }
            if(!$scope.newHote.libelleHote){
                $rootScope.$broadcast('showMessage',{
                    messages:["Veuillez fournir le libelle de l'hote"],
                    typeAlert:"danger"
                });
                return false;
            }
            return true;
        }


    }]);
