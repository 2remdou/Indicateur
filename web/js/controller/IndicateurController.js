/**
 * Created by delphinsagno on 15/03/15.
 */
app.controller('IndicateurController',['$scope','Restangular','$rootScope','indicateurFactory','typeIndicateurFactory','hoteFactory',
    function($scope,Restangular,$rootScope,indicateurFactory,typeIndicateurFactory,hoteFactory){
                intercepError(Restangular,$rootScope);

                $rootScope.$broadcast('hideMessage') ;
                $scope.all = function(){
                    $rootScope.loading=true;
                        indicateurFactory.getList().then(function(indicateurs){
                            $scope.indicateurs = indicateurs;
                            if(indicateurs.length===0){
                                $rootScope.$broadcast('showMessage',
                                    {messages:["Aucun indicateur pour le moment"],
                                        typeAlert:"info"
                                    }) ;
                            }
                            $rootScope.loading=false;
                        });
                };

                $scope.all();

                typeIndicateurFactory.getList().then(function(typeIndicateurs){
                    $scope.typeIndicateurs = typeIndicateurs;
                });

                hoteFactory.getList().then(function(hote){
                    $scope.hotes = hote;
                });

                $scope.newIndicateur = {};
                $scope.saveIndicateur = function(){
                    if(!controlFields()) return;
                    if($scope.method === "PUT"){
                        console.log($scope.newIndicateur);
                        $scope.newIndicateur.put().then(function(values){
                            $rootScope.$broadcast('showMessage',
                                {messages:["Modification effectuée"],
                                    typeAlert:"success"
                            }) ;
                        });
                        $scope.method = "POST";
                    }
                    else{
                       typeIndicateurFactory.one($scope.newIndicateur.typeIndicateur.id).post('indicateurs',$scope.newIndicateur)
                           .then(function(values){
                           $scope.all();
                           $scope.indicateurs.push($scope.newIndicateur);
                           $scope.newIndicateur = {};
                           $rootScope.$broadcast('showMessage',{
                               messages:["Enregistrement effectué"],
                               typeAlert:"success"
                           });

                       });
                    }

                };

                $scope.editIndicateur = function(index){
                    $scope.newIndicateur = {};
                    $scope.newIndicateur = $scope.indicateurs[index];
                    $scope.hotes = $scope.newIndicateur.hotes;
                    console.log($scope.newIndicateur);
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
                };

                $scope.annuler = function(){
                    $scope.method = "POST";
                    $scope.newIndicateur={};
                }

                function controlFields(){
                    if(!$scope.newIndicateur.typeIndicateur){
                        $rootScope.$broadcast('showMessage',{
                            messages:["Veuillez selectionner un type indicateur"],
                            typeAlert:"danger"
                        });
                        return false;
                    }
/*
                    if(!$scope.newIndicateur.hote){
                        $rootScope.$broadcast('showMessage',{
                            messages:["Veuillez selectionner un hote"],
                            typeAlert:"danger"
                        });
                        return false;
                    }
*/
                    return true;
                }

                function formatIndicateur(){
                    var indicateurs = [];
                    angular.forEach($scope.indicateurs,function(indicateur){
                            angular.forEach(indicateur.hotes,function(hote){
                                indicateur.hote=hote;
                                indicateurs.push(indicateur);
                                console.log(hote);
                                indicateur.hote={};
                            })
                    });
                    $scope.indicateurs = indicateurs;
                }
                $scope.selectedHote = function(hote){
                    var trouve=false;
                    var index=undefined;
                    angular.forEach($scope.newIndicateur.hotes,function(value,index){
                        console.log(value);
                        if(value.id===hote.id){
                            /*trouve = true;
                            index=index;*/

                        }
                    });
                   /* if(hote.selected && !trouve){
                        $scope.newIndicateur.hotes.push(hote);
                    }
                    else if(!hote.selected && trouve){
                        $scope.newIndicateur.hotes.splice(hote.id,1);
                    }*/
                }
}]);