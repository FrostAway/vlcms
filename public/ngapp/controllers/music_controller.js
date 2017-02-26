(function ($) {

    angular.module('musicController', [])
            .controller('musicController', function ($rootScope, $sce) {
                
                $rootScope.EL_CURRENT = null;
                $rootScope.ENDED = true;
                
                $rootScope.playAudio = function (item, $event) {
                    if ($($event.currentTarget).parent().hasClass('active')) {
                        return;
                    }
                    var url = item['@content.downloadUrl'];
                    _player.attr('src', url);
                    _player_box.find('._pl_title span').text(item.title || item.name);
                    _player_box.addClass('pl_show');
                    console.log(_player);
                    $rootScope.play();
                    $rootScope.EL_CURRENT = $($event.currentTarget);
                    $($event.currentTarget).closest('ul').find('li').removeClass('active');
                    $($event.currentTarget).parent().addClass('active');
                };

                $rootScope.$watch('ENDED', function (newVal, oldVal) {
                    if (newVal && $rootScope.EL_CURRENT) {
                        var el_this = $rootScope.EL_CURRENT;
                        var item_if = el_this.closest('.item_if');
                        if (item_if.next('.item_if').length > 0) {
                            var next_item = item_if.next('.item_if').find('li a');
                            _player.attr('src', next_item.data('src'));
                            _player_box.find('._pl_title span').text(next_item.data('title'));
                            $rootScope.play();
                            el_this.closest('ul').find('li').removeClass('active');
                            el_this.parent().addClass('active');
                        }
                    }
                });
                
                $rootScope.trustSrc = function (src) {
                    return $sce.trustAsResourceUrl(src);
                };
            })
            .controller('oneDriveController', function ($scope, oneDriveApi) {
                oneDriveApi.getByFolder(SHARE_ID).success(function (data) {
                    if (data.folder) {
                        $scope.childrens = data.children;
                    }
                });
            })
            .controller('folderController', function ($scope, $stateParams, oneDriveApi) {
                var folder_id = $stateParams.id;
                oneDriveApi.listInFolder(folder_id).success(function (data) {
                    console.log(data);
                    $scope.childrens = data.value;
                });
            })
            .controller('playerController', function ($scope, $rootScope, $interval, $timeout, oneDriveApi) {

                var audioTimeInterval;
                $scope.AUDIO = {};
                $scope.AUDIO.volumePercent = 100;
                $rootScope.play = function () {
                    $scope.AUDIO = document.getElementById('_player');

                    $rootScope.ENDED = false;
                    $scope.AUDIO.volumePercent = $scope.AUDIO.volume * 100;
                    if ($scope.AUDIO.paused) {
                        $scope.AUDIO.play();
                        audioTimeInterval = $interval(audioRunTime, 500);
                    } else {
                        $scope.AUDIO.pause();
                        $interval.cancel(audioTimeInterval);
                    }
                };

                $scope.seedAudio = function ($event) {
                    var seedWidth = $event.pageX - $($event.currentTarget).offset().left;
                    var barWidth = $($event.currentTarget).width();
                    $scope.AUDIO.percentTime = (seedWidth / barWidth) * 100;
                    $scope.AUDIO.currentTime = (seedWidth / barWidth) * $scope.AUDIO.duration;
                    $scope.AUDIO.roudCurrentTime = timeFormat($scope.AUDIO.currentTime);
                    $scope.AUDIO.roudDuration = timeFormat($scope.AUDIO.duration);
                };
                
                $scope.AUDIO.show = false;
                $scope.closePlayer = function () {
                    if (_player_box.hasClass('pl_show')) {
                        _player_box.removeClass('pl_show');
                        $scope.AUDIO.show = false;
                    } else {
                        _player_box.addClass('pl_show');
                        $scope.AUDIO.show = true;
                    }
                };

                $('._progress_node').each(function () {
                    var el_bar = $(this).closest('._progress_bar');
                    var barWidth = el_bar.width();
                    $(this).draggable({
                        axis: 'x',
                        containment: el_bar,
                        drag: function (event, ui) {
                            var seedWidth = ui.offset.left - el_bar.offset().left;
                            var percentTime = (seedWidth / barWidth) * 100;
                            $scope.$apply(function () {
                                $scope.AUDIO.percentTime = percentTime;
                                $scope.AUDIO.currentTime = percentTime * $scope.AUDIO.duration / 100;
                                $scope.AUDIO.roudCurrentTime = timeFormat($scope.AUDIO.currentTime);
                                $scope.AUDIO.roudDuration = timeFormat($scope.AUDIO.duration);
                            });
                        }
                    });
                });

                $('._volume_node').each(function () {
                    var el_bar = $(this).closest('._volume_bar');
                    var barWidth = el_bar.width();
                    $(this).draggable({
                        axis: 'x',
                        containment: el_bar,
                        drag: function (event, ui) {
                            var seedWidth = ui.offset.left - el_bar.offset().left;
                            var percentVolume = seedWidth / barWidth;
                            $scope.$apply(function () {
                                $scope.AUDIO.volume = percentVolume;
                                $scope.AUDIO.volumePercent = percentVolume * 100;
                            });
                        }
                    });
                });

                function audioRunTime() {
                    if ($scope.AUDIO.ended) {
                        $rootScope.ENDED = true;
                        $interval.cancel(audioTimeInterval);
                    } else {
                        $scope.AUDIO.percentTime = ($scope.AUDIO.currentTime / $scope.AUDIO.duration) * 100;
                        $scope.AUDIO.roudCurrentTime = timeFormat($scope.AUDIO.currentTime);
                        if ($scope.AUDIO.percentTime >= 100) {
                            $interval.cancel(audioTimeInterval);
                        }
                    }
                    if (!isNaN($scope.AUDIO.duration)) {
                        $scope.AUDIO.roudDuration = timeFormat($scope.AUDIO.duration);
                    }
                }

                function timeFormat(time) {
                    var minute = Math.floor(time / 60);
                    var second = Math.floor(time % 60);
                    return (minute < 10 ? '0' + minute : minute) + ':' + (second < 10 ? '0' + second : second);
                }
            });

})(jQuery);


