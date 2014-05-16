<div class="container">
    <h1>Friends of {username}:</h1>
    {validation_errors}
    <table>
        <tr>
            <th>Username</th>
            <th>City</th>
            <th>level</th>
        </tr>
        {friends}
        <tr>
            <td>{friendname}</td><td>{city}</td><td>{level}</td>
        </tr>
        {/friends}
    </table>
    {form_open}
    <div class="form-group">
        <label for="addFriend" class="control-label col-lg-3">Add a Friend:</label>
        <div class="col-lg-3">
            <input type="text" name="searchName" class="form-control"/>
        </div>
        <div class="col-lg-3">
            <button type="submit" class="btn btn-primary">Add</button>
        </div>
    </div> 
    {form_close}
</div>

