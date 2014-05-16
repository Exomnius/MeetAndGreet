<div class="container">
    <div class="col-xs-12">
        <h1>Friends of {username}</h1>
        

        {validation_errors}
        <table class="table table-bordered" style="margin-bottom: 20px;">
            <tr style="">
                <th>Username</th>
                <th>City</th>
                <th>level</th>
            </tr>
            {friends}
            <tr style="">
                <td style=" padding-top: 5px; padding-right: 30px;">{friendname}</td><td style=" padding-top: 5px; padding-right: 30px;">{city}</td><td style="padding-top: 5px; padding-right: 30px;">{level}</td>
            </tr>
            {/friends}
        </table>
    </div>
    <div class="col-xs-12">
        <div class="addFriend">
            {form_open}
            <label for="addFriend" class="control-label">Add a Friend</label><br>
            <div class="">
                <input type="text" name="searchName" class="form-control"/>
            </div>
            <div class="">
                <button type="submit" class="btn btn-primary">Add</button>
            </div>
            {form_close}
        </div>
    </div>
