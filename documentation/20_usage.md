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

## Automatically handling Steam data
TODO: explain commands

- `passioneight:steam-web-api:update-profiles`
- `passioneight:steam-web-api:update-games`

## Manually using the API
To use the API, inject the `SteamWebApiService` and call any of the provided methods. In case you need a different
kind of version for an endpoint, call `useVersion(...)`.

> The `useVersion` method will actually set the version, i.e., you need to call `resetVersion()` if any subsequent API calls
> should use the default version.

An example API call looks like this:

```php
$response = $steamWebApiService
    ->useVersion(SteamWebApiService::VERSION_2)
    ->getPlayerSummaries($steamId);
```

> Always make sure to call the correct version of the API, as otherwise you might get an error response.




> You are limited to one hundred thousand (100,000) calls to the Steam Web API per day.
> Valve may approve higher daily call limits if you adhere to these API Terms of Use.

### [Next Chapter: Customization](/documentation/30_customization.md)