# API Endpoints

This tests uses a few fake developer endpoints that pull sports related information.

The default endpoint used to pull All Black information comes from:

`https://www.zeald.com/developer-tests-api/x_endpoint/allblacks`

Data is provided in JSON format and suppliers a small subset of All Black player information & statistics. All requests are treated as `GET` requests.

All endpoints require an API key to be sent through with each request as a querystring `API_KEY` parameter added to each request.

API Key: `few823mv__570sdd0342`

So your `GET` request should look like: `https://www.zeald.com/developer-tests-api/x_endpoint/allblacks?API_KEY=few823mv__570sdd0342`


## Example response

An example response from a request to the API is:

```jsonc
[
    {
        "id": 3,
        "name": "Ardie Savea",
        "number": 6,
        "position": "Loose Forward",
        "height": 190,
        "weight": 99,
        "age": 28,
        "points": 75,
        "games": 59,
        "tries": 15,
        "conversions": 0,
        "penalties": 0
    },
    // other objects
]
```


## Additional endpoints

Parts of the tests will require you to access additional endpoints to retrieve NBA player information & statistics. These are available at:

### Player data
NBA player data can be retrieved from the endpoint at `https://www.zeald.com/developer-tests-api/x_endpoint/nba.players`

An example response is as follows:

```jsonc
[
    {
        "id": 2,
        "first_name": "Stephen",
        "last_name": "Curry",
        "number": 30,
        "position": "guard",
        "feet": 6,
        "inches": 2,
        "weight": 84,
        "birthday": "1988-03-14",
        "current_team": "GSW"
    },
    // other objects
]
```

### Player statistics
Player statistics can be retrieved from a separate endpoint: `https://www.zeald.com/developer-tests-api/x_endpoint/nba.stats`

This endpoint returns a response that looks like:

```jsonc
[
    {
        "id": 24,
        "assists": 5204,
        "points": 21063,
        "rebounds": 4295,
        "games": 826,
        "player_id": 2
    },
    // other objects
]
```

These endpoints only contain a small subset of players - mainly from the Golden State Warriors.

## Filtering

To filter the data, you can append to the endpoint URL the name of any key returned by a row of data, followed by a `/` then a value to filter by.

For example in the `allblacks` data, you could append `/id/1` - making it `https://www.zeald.com/developer-tests-api/x_endpoint/allblacks/id/1` to retrieve only Aaron Smith's information.

Equally [https://www.zeald.com/developer-tests-api/x_endpoint/allblacks/position/Loose Forward](https://www.zeald.com/developer-tests-api/x_endpoint/allblacks/position/Loose+Forward?API_KEY=few823mv__570sdd0342) would retrieve all loose forwards.

To retrieve multiple values, pass them comma separated. E.g. [https://www.zeald.com/developer-tests-api/x_endpoint/nba.players/position/guard,center](https://www.zeald.com/developer-tests-api/x_endpoint/nba.players/position/guard,center?API_KEY=few823mv__570sdd0342) would retrieve all guards & centers from the NBA players endpoint.
