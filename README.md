# Steam Web API
This **Pimcore**-bundle provides an API and corresponding `DataObject`s, which can be used to link a user with their
[Steam](https://store.steampowered.com/) profile and load any publicly available information.

> Information that is classified by Steam as private is also supported, but can only be loaded if the profile settings
> of the user allow it.

###### Table of contents
- [Installation](/documentation/10_installation.md)
- [Prerequisites](/documentation/15_prerequisites.md)
- [Configuration](/documentation/19_configuration.md)
- [Usage](/documentation/20_usage.md)
  - [Open ID](/documentation/20_usage.md#open-id)
  - [Using the API](/documentation/20_usage.md#using-the-api)

# When should I use this bundle?
If you are using Pimcore to create a project that needs information about a user's Steam profile. Or you just want the
user to be able to link their Steam account to your website.

# Why should I use this bundle?
Steam's Web API is rather cumbersome and often outdated or a bit messy. It takes a while to fully understand how to use
it - especially linking a Steam profile.

This bundle will ease the process of fetching data from Steam comes with a pre-built data-model.

# Implemented Endpoints
- [IPlayerService](https://partner.steamgames.com/doc/webapi/IPlayerService)
  - GetRecentlyPlayedGames
  - GetOwnedGames
  - GetSteamLevel
  - GetBadges
  - GetCommunityBadgesProgress
  - IsPlayingSharedGame
- [ISteamNews](https://partner.steamgames.com/doc/webapi/ISteamNews)
  - GetNewsForApp
- [ISteamApps](https://partner.steamgames.com/doc/webapi/ISteamApps)
  - GetAppList
- [ISteamUser](https://partner.steamgames.com/doc/webapi/ISteamUser)
  - GetFriendList
  - GetPlayerBans
  - GetPlayerSummaries
  - GetUserGroupList
  - ResolveVanityUrl
- [ISteamUserStats](https://partner.steamgames.com/doc/webapi/ISteamUserStats)
  - GetGlobalAchievementPercentagesForApp
  - GetGlobalStatsForGame
  - GetNumberOfCurrentPlayers
  - GetPlayerAchievements
  - GetSchemaForGame
  - GetUserStatsForGame
- [ISteamWebAPIUtil](https://partner.steamgames.com/doc/webapi/ISteamWebAPIUtil)
  - GetServerInfo
  - GetSupportedAPIList

> Note that this bundle only implements the non-partner bit of [Steam's Web API](https://partner.steamgames.com/doc/webapi).