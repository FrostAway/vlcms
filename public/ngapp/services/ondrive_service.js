angular.module('musicService', [])
        .factory('oneDriveApi', function ($http) {
            return {
                getByFolder: function (share_id) {
                    return $http.get('https://api.onedrive.com/v1.0/shares/'+ share_id +'/root?expand=children');
                },
                listInFolder: function (folder_id) {
                    return $http.get('https://api.onedrive.com/v1.0/shares/' + SHARE_ID + '/items/'+ folder_id +'/children');
                },
                loadFile: function (file_src) {
                    return $http.get(file_src);
                }
            };
        });


