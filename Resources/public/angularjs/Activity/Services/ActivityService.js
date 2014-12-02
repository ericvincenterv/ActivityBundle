(function () {
    'use strict';

    angular.module('Activity').factory('ActivityService', [
        '$http',
        function ($http) {
            return {

                addActivity: function() {
                    var deferred = $q.defer();
                    deferred.notify();
                    LoaderService.startRequest();
                    $http.get(Routing.generate('activity_add_activity', { activityId: activity.id }))
                    .success(function (data) {
                        deferred.resolve(data.activity);
                        activitySequence.activities.push(data.activity);
                        LoaderService.endRequest();
                    });

                    return deferred.promise;
                },

                deleteActivity: function(activityId) {
                    var deferred = $q.defer();
                    deferred.notify();
                    LoaderService.startRequest();

                    $http.delete(Routing.generate('delete_activity', { activityId: activityId }))
                    .success(function (data) {
                        deferred.resolve(JSON.parse(data.activity));
                        LoaderService.endRequest();
                    });

                    return deferred.promise;
                },

                save: function (activity) {
                    // Init
                    var data = {
                        id          : activity.id,
                        typology    : activity.typology,
                        description : activity.description
                    };

                    $http({
                        method: 'GET',
                        url: Routing.generate('activity_sequence_add_activity', {activitySequenceId : activity.id}),
                        data: data
                    })
                    .success(function (data) {
                    })
                    .error(function(data, status) {
//                        AlertFactory.addAlert('danger', 'Error while adding activity.');
                    });
                }
            };
        }
    ]);
})();