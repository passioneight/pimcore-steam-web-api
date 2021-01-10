# Usage
Depending on how you want to use this bundle, there are a few things to consider.

## Linking the User's Profile
When it comes to linking the user's Steam profile, consider the following:
- a `DataObject`-class is needed - e.g., `SteamProfile`
  - must contain a `Text`-field `steamId`
- a `UserInterface` object is needed - i.e., a user must be authenticated via Symfony
  - must contain a `Relation`-field `steamProfile`
- an `EventSubscriber` is needed - e.g. `SteamOpenIdSubscriber`

> All the things above are quite project-specific, which is why they are not included in this bundle.

Assuming that all classes are created within Pimcore as described above, you'll actually only need to implement the
`SteamOpenIdSubscriber` class. To help ease this process, you may extend from the `SteamOpenIdSubscriber` class provided
by this bundle.

An example may look like this:
```php
<?php

namespace AppBundle\EventSubscriber\Steam;

use Passioneight\Bundle\PimcoreSteamWebApiBundle\Event\OpenId\AlreadyConnectedEvent;
use Passioneight\Bundle\PimcoreSteamWebApiBundle\Event\OpenId\AlreadyDisconnectedEvent;
use Passioneight\Bundle\PimcoreSteamWebApiBundle\Event\OpenId\ConnectedEvent;
use Passioneight\Bundle\PimcoreSteamWebApiBundle\Event\OpenId\CouldNotConnectEvent;
use Passioneight\Bundle\PimcoreSteamWebApiBundle\Event\OpenId\CouldNotDisconnectEvent;
use Passioneight\Bundle\PimcoreSteamWebApiBundle\Event\OpenId\DisconnectedEvent;
use Passioneight\Bundle\PimcoreSteamWebApiBundle\EventSubscribers\SteamOpenIdSubscriber as AbstractSteamOpenIdSubscriber;
use Pimcore\Model\DataObject\SteamProfile;
use Pimcore\Model\DataObject\User;
use Symfony\Component\HttpFoundation\RedirectResponse;

class SteamOpenIdSubscriber extends AbstractSteamOpenIdSubscriber
{
    /**
     * @inheritdoc
     */
    public function onConnected(ConnectedEvent $event)
    {
        $steamProfile = new SteamProfile();
        $steamProfile->setPublished(true);
        $steamProfile->setKey($event->getSteamId());
        $steamProfile->setParent('/Steam/Profiles');    // Change as needed
        $steamProfile->setSteamId($event->getSteamId());
        $steamProfile->save(['versionNote' => 'Linked Steam account']);
        
        /** @var User $user */
        $user = $event->getUser();
        $user->setSteamProfile($steamProfile);
        $user->save(['versionNote' => 'Linked Steam account']);

        $event->setResponse(new RedirectResponse($event->getUser()->getDetailLink()));
    }

    /**
     * @inheritdoc
     */
    public function onDisconnected(DisconnectedEvent $event)
    {
        $event->setResponse(new RedirectResponse($event->getUser()->getDetailLink()));
    }

    /**
     * @inheritdoc
     */
    public function onAlreadyConnected(AlreadyConnectedEvent $event)
    {
        $event->setResponse(new RedirectResponse($event->getUser()->getDetailLink()));
    }

    /**
     * @inheritdoc
     */
    public function onAlreadyDisconnected(AlreadyDisconnectedEvent $event)
    {
        $event->setResponse(new RedirectResponse($event->getUser()->getDetailLink()));
    }

    /**
     * @inheritdoc
     */
    public function onCouldNotConnect(CouldNotConnectEvent $event)
    {
        $event->setResponse(new RedirectResponse($event->getUser()->getDetailLink()));
    }

    /**
     * @inheritdoc
     */
    public function onCouldNotDisconnect(CouldNotDisconnectEvent $event)
    {
        $event->setResponse(new RedirectResponse($event->getUser()->getDetailLink()));
    }
}
```

For the sake of simplicity, we always want to redirect to the user's profile page - i.e., the detail link. However, you
probably want to display corresponding flash messages or do something completely different.

> The `getDetailLink` can be implemented using a `LinkGenerator`. See Pimcore's documentation for further details.

Now that un-/linking is possible, the only thing left to do is generating the links for the user to click on. Simply inject
the `SteamOpenId` service into your controller and call the following methods to generate the links:

```php
$linkSteamAccountUrl = $steamOpenId->generateLinkSteamAccountUrl();
$unlinkSteamAccountUrl = $steamOpenId->generateUnlinkSteamAccountUrl();
```

Note that at this point the user will only have a `SteamProfile` containing the `steamId` - nothing else. You can either
update the `SteamProfile` via the API right away or implement a `Command` so you can update the `SteamProfile` on a regular
basis.

> Obviously, you'll need to update the `SteamProfile` class to support any needed fields.

> Mind the request limit of Steam's API.

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

> Always make sure to call the correct version of the API, as otherwise you might get an error response.

> The `useVersion` method will actually set the version, i.e., you need to call `resetVersion()` if any subsequent API calls
> should use the default version.

Most of the API calls support passing options _to the API_. For example, when an endpoint allows to filter the result with
parameters sent via the request. However, sometimes the options can be passed merely for the sake of support of future updates
of Steam's API. So, make sure you check out Steam's documentation to see what versions and options are available for the
corresponding endpoints.

### [Go back to overview](/README.md)