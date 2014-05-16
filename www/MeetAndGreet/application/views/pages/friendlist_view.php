<div class="container">
    <div class="col-xs-12">
        <div class="col-xs-12">
            <h1>Friends of {username}:</h1>
        </div>

        {validation_errors}
        <table class="col-lg-4" style="margin-bottom: 20px;">
            <tr style="border-bottom: 3px solid black">
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
    <div class="col-xs-12 text-right">
        <div class="">
            {form_open}
            <label for="addFriend" class="control-label col-lg-5">Add a Friend:</label>
            <div class="col-xs-3">
                <input type="text" name="searchName" class="form-control"/>
            </div>
            <div class="col-xs-1">
                <button type="submit" class="btn btn-primary">Add</button>
            </div>
            {form_close}
        </div>
    </div>
