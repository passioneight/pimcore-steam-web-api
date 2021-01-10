# Usage
Depending on how you want to use this bundle, there are a few things to consider.

## Open ID
If you want to let the user link their Steam account using `OpenId`, you'll want to have a `User` class, which contains
the `relation`-field `steamProfile`.

> Note that you don't need to name the class `User` - so, `Customer`, `Player` and so on are valid too.
> However, the `User` class is assumed. Thus, any command will work out-of-the-box with this class, but provides
> a corresponding option to change it.

Once the class is ready, the following code will generate the required links - provided the
`SteamOpenId` service was injected:

```php
$linkSteamAccountUrl = $steamOpenId->generateLinkSteamAccountUrl();
$unlinkSteamAccountUrl = $steamOpenId->generateUnlinkSteamAccountUrl();
```

Generate and display the links when needed and the user can link their Steam profile.

> Note that at this point the user will only have a `SteamProfile` with a `Steam ID` - nothing else. If you need to update
> right away, leverage the `OpenIdEvent` and checkout the [section on how to manually use the API](#manually-using-the-api).

> #### Please note
> Steam **does not** use `OpenId Connect`, but `OpenId` directly.
> Thus, linking the Steam account doesn't actually do much, but return the
> user's `Steam ID` - wich in turn is saved in a `SteamProfile` object.
> 
> This means, unlinking can only be done by deleting the `SteamProfile` object or
> removing the `Steam ID` from it. However, you'll want to eventually delete any data
> related to the user's Steam profile, due to GDPR reasons.

## Using the API
To use the API, inject the needed `SteamWebApi` service, i.e. either of:
- `SteamAppsApi`
- `SteamNewsApi`
- `SteamPlayerServiceApi`
- `SteamUserApi`
- `SteamUserStatsApi`
- `SteamUtilApi`

An example API call looks like this:

```php
$response = $steamPlayerService
    ->useVersion(SteamWebApi::VERSION_2)
    ->getPlayerSummaries($steamId);
```

As shown in the code above: In case you need a different kind of version for an endpoint, call `useVersion(...)`.

Always make sure to call the correct version of the API, as otherwise you might get an error response.

> The `useVersion` method will actually set the version, i.e., you need to call `resetVersion()` if any subsequent API calls
> should use the default version.

Most of the API calls support passing options _to the API_. For example, when an endpoint allows to filter the result with
parameters sent via the request. However, sometimes the options can be passed merely for the sake of support of future updates
of Steam's API. So, make sure you check out Steam's documentation to see what versions and options are available for the
corresponding endpoints.

### [Go back to overview](/README.md)