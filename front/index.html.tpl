    <div class="container">
        <div class="starter-template">
            <br/> <br/>
            <div class="row">
                    Posts: {{posts}} <button type="button" class="btn btn-primary btn-lg">Export</button> Views: {{views}}
            </div>
            <br/> <br/>
            <div class="row">
                <form class="form-inline">
                <div class="form-group">
                    <input type="text" class="form-control" ng-model="title" id="title"  name="title" placeholder="Image title" >
                    <input type="file" file-model="imageFile">
                    <button ng-click="upload()" class="btn btn-primary btn-lg">Upload image</button>
                </div>
                </form>
            </div>
            <br/> <br/>
            <div ng-repeat="image in listImages">
                <div class="row">
                    <p>{{image.title}}</p>
                    <img src="images/{{image.name}}" width="300" height="250"/>
                    <br/>
                    <br/>
                </div>
            </div>
        </div>
    </div><!-- /.container -->


