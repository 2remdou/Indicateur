/**
 * Created by mdoutoure on 18/03/2015.
 */
app.factory('hoteFactory',function(Restangular){
    return Restangular.service(getRoute('get_hotes'));
});