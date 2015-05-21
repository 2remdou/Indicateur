/**
 * Created by delphinsagno on 15/03/15.
 */
app.controller('IndicateurController',['$scope','Restangular','$rootScope','indicateurFactory','typeIndicateurFactory','hoteFactory','uniteFactory',
    function($scope,Restangular,$rootScope,indicateurFactory,typeIndicateurFactory,hoteFactory,uniteFactory){
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

                uniteFactory.getList().then(function(unites){
                    $scope.unites = unites;
                })

                $scope.newIndicateur = {};
                $scope.saveIndicateur = function(){
                    if(!controlFields()) return;
                    if($scope.method === "PUT"){
                        $scope.newIndicateur.put().then(function(values){
                            $rootScope.$broadcast('showMessage',
                                {messages:["Modification effectuée"],
                                    typeAlert:"success"
                            }) ;
                        });
                        $scope.method = "POST";
                    }
                    else{
                       typeIndicateurFactory.one($scope.newIndicateur.typeIndicateur.id)
                           .one(getRoute('get_unites'),$scope.newIndicateur.unite.id)
                           .post('indicateurs',$scope.newIndicateur)
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
                    //on deselectionne tout
                    angular.forEach($scope.hotes,function(hoteAll){
                            hoteAll.selected=false;
                    });
                    //on reselectionne en fonction de l'indicateur selectionne
                    angular.forEach($scope.newIndicateur.hotes,function(hoteSelect){
                        angular.forEach($scope.hotes,function(hoteAll){
                            if(hoteSelect.id===hoteAll.id){
                                hoteAll.selected=true;
                            }
                        });
                    });
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
                    var pos=undefined;
                    //creer un tab vide pour les hotes
                   if(typeof $scope.newIndicateur.hotes==="undefined"){
                       $scope.newIndicateur.hotes=[];
                   }
                    angular.forEach($scope.newIndicateur.hotes,function(value,index){
                        if(value.id===hote.id){
                            trouve = true;
                            pos=index;
                        }
                    });
                    //l'hote selectionne n'existe pas dans l'indicateur selectionne
                   if(hote.selected){
                       if(!trouve){
                           $scope.newIndicateur.hotes.push(hote);
                       }
                    }
                    else{ //l'hote deselectionne existe dans l'indicateur selectionne
                        if(trouve){
                            $scope.newIndicateur.hotes.splice(pos,1);
                        }
                    }
                }
}]);