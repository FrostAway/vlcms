<?php include_once 'header.php'; ?>

<div>
    <div class="_wrapper _upload_box">
        <ul class="nav nav-tabs _upload-tabs" role="tablist">
            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#video_upload" role="tab"><i class="fa fa-youtube"></i> Video</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#music_upload" role="tab"><i class="fa fa-music"></i> Nhạc</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#image_upload" role="tab"><i class="fa fa-image"></i> Hình ảnh</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="video_upload" role="tabpanel">
                <div class="upload_container _table">
                    <div class="_table_cell">
                        <h3 class="_box_title">Nhập đường dẫn video (youtube)</h3>
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" class="form-control">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary"><i class="fa fa-upload"></i> Upload</button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="music_upload" role="tabpanel">
                <div class="upload_container">
                    <h3 class="_box_title">Tải nhạc lên</h3>
                    <div class="form-group">
                        <label class="_upload_zone">
                            <input type="file">
                            <span class="_cell">
                                <span class="btn btn-secondary"><i class="fa fa-file"></i> Chọn file</span>
                            </span>
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-upload"></i> Upload</button>
                </div>
            </div>
            <div class="tab-pane" id="image_upload" role="tabpanel">
                <div class="upload_container">
                    <h3 class="_box_title">Tải ảnh lên</h3>
                    <div class="form-group">
                        <label class="_upload_zone">
                            <input type="file">
                            <span class="_cell">
                                <span class="btn btn-secondary"><i class="fa fa-file"></i> Chọn file</span>
                            </span>
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-upload"></i> Upload</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once 'footer.php'; ?>

