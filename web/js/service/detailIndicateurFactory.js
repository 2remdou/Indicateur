/**
 * Created by mdoutoure on 18/03/2015.
 */
app.factory('detailIndicateurFactory',function(Restangular){
    return Restangular.service(getRoute('get_detail_indicateurs'));
});