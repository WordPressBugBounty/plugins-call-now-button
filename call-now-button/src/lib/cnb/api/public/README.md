# OpenAPIClient-php

API for CallNowButton. Includes auth, domains, buttons/actions/conditions, but also chat and admin features.

For more information, please visit [https://nowbuttons.com/support/](https://nowbuttons.com/support/).

## Installation & Usage

### Requirements

PHP 7.4 and later.
Should also work with PHP 8.0.

### Composer

To install the bindings via [Composer](https://getcomposer.org/), add the following to `composer.json`:

```json
{
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/GIT_USER_ID/GIT_REPO_ID.git"
    }
  ],
  "require": {
    "GIT_USER_ID/GIT_REPO_ID": "*@dev"
  }
}
```

Then run `composer install`

### Manual Installation

Download the files and include `autoload.php`:

```php
<?php
require_once('/path/to/OpenAPIClient-php/vendor/autoload.php');
```

## Getting Started

Please follow the [installation procedure](#installation--usage) and then run the following:

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



// Configure API key authorization: sessionCookieScheme
$config = cnb\api\Configuration::getDefaultConfiguration()->setApiKey('SESSION', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = cnb\api\Configuration::getDefaultConfiguration()->setApiKeyPrefix('SESSION', 'Bearer');

// Configure API key authorization: apikeyScheme
$config = cnb\api\Configuration::getDefaultConfiguration()->setApiKey('x-cnb-api-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = cnb\api\Configuration::getDefaultConfiguration()->setApiKeyPrefix('x-cnb-api-key', 'Bearer');


$apiInstance = new cnb\api\Api\ActionApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$action_create_request = new \cnb\api\Model\ActionCreateRequest(); // \cnb\api\Model\ActionCreateRequest

try {
    $result = $apiInstance->create($action_create_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ActionApi->create: ', $e->getMessage(), PHP_EOL;
}

```

## API Endpoints

All URIs are relative to *http://localhost:8080*

Class | Method | HTTP request | Description
------------ | ------------- | ------------- | -------------
*ActionApi* | [**create**](docs/Api/ActionApi.md#create) | **POST** /v1/action | Create an &#x60;Action&#x60;
*ActionApi* | [**delete**](docs/Api/ActionApi.md#delete) | **DELETE** /v1/action/{actionId} | Delete an &#x60;Action&#x60;
*ActionApi* | [**get**](docs/Api/ActionApi.md#get) | **GET** /v1/action/{actionId} | Get an &#x60;Action&#x60; by its ID
*ActionApi* | [**getAll**](docs/Api/ActionApi.md#getall) | **GET** /v1/action | Get all &#x60;Action&#x60;s for this User
*ActionApi* | [**getButtons**](docs/Api/ActionApi.md#getbuttons) | **GET** /v1/action/button/{actionId} | Get the &#x60;Button&#x60;s associated with this &#x60;Action&#x60;
*ActionApi* | [**getButtonsFull**](docs/Api/ActionApi.md#getbuttonsfull) | **GET** /v1/action/button/{actionId}/full | Get the associated single Full &#x60;Button&#x60; for this &#x60;Action&#x60;
*ActionApi* | [**update**](docs/Api/ActionApi.md#update) | **PATCH** /v1/action/{actionId} | Update an &#x60;Action&#x60;
*ApikeyApi* | [**create**](docs/Api/ApikeyApi.md#create) | **POST** /v1/apikey | Create a new &#x60;Apikey&#x60;. Also returns the actual API key (which cannot be retrieved again later).
*ApikeyApi* | [**delete**](docs/Api/ApikeyApi.md#delete) | **DELETE** /v1/apikey/{apikeyId} | Delete an Apikey for the current User
*ApikeyApi* | [**get**](docs/Api/ApikeyApi.md#get) | **GET** /v1/apikey/{apikeyId} | Get an &#x60;Apikey&#x60; by its ID
*ApikeyApi* | [**getAll**](docs/Api/ApikeyApi.md#getall) | **GET** /v1/apikey | Retrieve the existing created API keys.
*ApikeyApi* | [**getByOneTimeToken**](docs/Api/ApikeyApi.md#getbyonetimetoken) | **GET** /v1/apikey/ott/{oneTimeToken} | Retrieve an API key by a single-use token. This token is generally only valid for 1 hour.
*ApikeyApi* | [**getByOneTimeTokenAndSecretKey**](docs/Api/ApikeyApi.md#getbyonetimetokenandsecretkey) | **GET** /v1/apikey/ott/{oneTimeToken}/{secretKey} | Retrieve an API key by a single-use token and a secret token. This token is generally only valid for 1 hour.
*ApikeyApi* | [**update**](docs/Api/ApikeyApi.md#update) | **PATCH** /v1/apikey/{apikeyId} | Update an &#x60;Apikey&#x60;. Currently only the name can be updated.
*ButtonApi* | [**copy**](docs/Api/ButtonApi.md#copy) | **POST** /v1/button/copy | Copy buttons from source domain to target (and optionally the domain Properties) within the same Account
*ButtonApi* | [**create**](docs/Api/ButtonApi.md#create) | **POST** /v1/button | Create a &#x60;Button&#x60;
*ButtonApi* | [**createFull**](docs/Api/ButtonApi.md#createfull) | **POST** /v1/button/full | Create a &#x60;Button&#x60; and return a Full &#x60;Button&#x60;
*ButtonApi* | [**createV2**](docs/Api/ButtonApi.md#createv2) | **POST** /v1/button/full-v2 | Create a &#x60;Button&#x60; and return a Full &#x60;Button&#x60;
*ButtonApi* | [**delete**](docs/Api/ButtonApi.md#delete) | **DELETE** /v1/button/{buttonId} | Delete a &#x60;Button&#x60;
*ButtonApi* | [**export**](docs/Api/ButtonApi.md#export) | **POST** /v1/button/export | Export buttons (and optionally the domain Properties)
*ButtonApi* | [**get**](docs/Api/ButtonApi.md#get) | **GET** /v1/button/{buttonId} | Get a single &#x60;Button&#x60;
*ButtonApi* | [**getAll**](docs/Api/ButtonApi.md#getall) | **GET** /v1/button | Get all buttons.
*ButtonApi* | [**getAllForDomain**](docs/Api/ButtonApi.md#getallfordomain) | **GET** /v1/button/byDomainId/{domainId} | Get all &#x60;Button&#x60;s for a single &#x60;Domain&#x60;.
*ButtonApi* | [**getAllFull**](docs/Api/ButtonApi.md#getallfull) | **GET** /v1/button/full | Get all &#39;full&#39; Buttons (meaning they have the &#x60;Domain&#x60; serialized).
*ButtonApi* | [**getAllValidationErrors**](docs/Api/ButtonApi.md#getallvalidationerrors) | **GET** /v1/button/validation | Get all validation errors for all Buttons.
*ButtonApi* | [**getFull**](docs/Api/ButtonApi.md#getfull) | **GET** /v1/button/{buttonId}/full | Get a single Full &#x60;Button&#x60;
*ButtonApi* | [**getValidationErrors**](docs/Api/ButtonApi.md#getvalidationerrors) | **GET** /v1/button/{buttonId}/validation | Get all validation errors for this Buttons.
*ButtonApi* | [**import**](docs/Api/ButtonApi.md#import) | **POST** /v1/button/import | Import buttons (and optionally the domain Properties)
*ButtonApi* | [**update**](docs/Api/ButtonApi.md#update) | **PATCH** /v1/button/{buttonId} | Update a &#x60;Button&#x60;
*ButtonApi* | [**updateFull**](docs/Api/ButtonApi.md#updatefull) | **PATCH** /v1/button/{buttonId}/full | Update a &#x60;Button&#x60; and return a Full &#x60;Button&#x60;
*ButtonApi* | [**updateFullV2**](docs/Api/ButtonApi.md#updatefullv2) | **PATCH** /v1/button/{buttonId}/full-v2 | Update a &#x60;Button&#x60; and return a Full &#x60;Button&#x60;
*ChatApi* | [**addMemberAsChatAgent**](docs/Api/ChatApi.md#addmemberaschatagent) | **POST** /v1/chat/workspace/{workspaceId}/member/{memberId}/addagent | Add a (new) &#x60;User&#x60; as a Member to a Workspace. Also creates a Chat Persona
*ChatApi* | [**addParticipant**](docs/Api/ChatApi.md#addparticipant) | **POST** /v1/chat/workspace/{workspaceId}/channel/{channelId}/participant/{personaId} | Add a Chat Agent as a participant to this Channel.
*ChatApi* | [**createPersona**](docs/Api/ChatApi.md#createpersona) | **POST** /v1/chat/workspace/{workspaceId}/member/{memberId}/persona | create a Chat User profile for the provided WorkspaceMember.
*ChatApi* | [**createPrivateNote**](docs/Api/ChatApi.md#createprivatenote) | **POST** /v1/chat/workspace/{workspaceId}/channel/{channelId}/notes | Create a new private note for a channel
*ChatApi* | [**createQuickReply**](docs/Api/ChatApi.md#createquickreply) | **POST** /v1/chat/workspace/{workspaceId}/{domainId}/quickreply | Create a quick reply
*ChatApi* | [**createWorkspaceDomainPersona**](docs/Api/ChatApi.md#createworkspacedomainpersona) | **POST** /v1/chat/workspace/{workspaceId}/domain/{domainId}/persona | 
*ChatApi* | [**delete**](docs/Api/ChatApi.md#delete) | **DELETE** /v1/chat/workspace/{workspaceId}/channel/{channelId} | Deletes a Chat Channel of this user
*ChatApi* | [**deleteQuickReply**](docs/Api/ChatApi.md#deletequickreply) | **DELETE** /v1/chat/workspace/{workspaceId}/{domainId}/quickreply/{quickReplyId} | Delete a quick reply
*ChatApi* | [**deleteWorkspace**](docs/Api/ChatApi.md#deleteworkspace) | **DELETE** /v1/chat/workspace/{workspaceId} | Delete a Workspace. This is permanent and can only be done if a workspace does not contain any domains.
*ChatApi* | [**disableChatUser**](docs/Api/ChatApi.md#disablechatuser) | **DELETE** /v1/chat/user/enable | Remove the chat user role from the current user
*ChatApi* | [**enableChatUser**](docs/Api/ChatApi.md#enablechatuser) | **POST** /v1/chat/user/enable | Add the chat user role to the current user
*ChatApi* | [**events**](docs/Api/ChatApi.md#events) | **GET** /v1/chat/workspace/{workspaceId}/channel/{channelId}/events | Gets all Events of this Channel, ordered by createdAt
*ChatApi* | [**exportChatChannelAsHtml**](docs/Api/ChatApi.md#exportchatchannelashtml) | **GET** /v1/chat/workspace/{workspaceId}/channel/{channelId}/html | 
*ChatApi* | [**exportChatChannelAsPdf**](docs/Api/ChatApi.md#exportchatchannelaspdf) | **GET** /v1/chat/workspace/{workspaceId}/channel/{channelId}/pdf | Export chat channel as PDF
*ChatApi* | [**get**](docs/Api/ChatApi.md#get) | **GET** /v1/chat/workspace/{workspaceId}/channel/{channelId} | Get a chat channel for the user
*ChatApi* | [**getAll**](docs/Api/ChatApi.md#getall) | **GET** /v1/chat/workspace/{workspaceId}/channels | Get all chat channels for the user
*ChatApi* | [**getAllBots**](docs/Api/ChatApi.md#getallbots) | **GET** /v1/chat/workspace/{workspaceId}/domain/{domainId}/bots | Get all available bots for this Workspace domain.
*ChatApi* | [**getAllPersonas**](docs/Api/ChatApi.md#getallpersonas) | **GET** /v1/chat/workspace/{workspaceId}/members/persona | Get all ChatAgentPersona profiles for this Workspace.
*ChatApi* | [**getFull**](docs/Api/ChatApi.md#getfull) | **GET** /v1/chat/workspace/{workspaceId}/channel/{channelId}/full | Get a chat channel w/ all metadata for the user
*ChatApi* | [**getPersona**](docs/Api/ChatApi.md#getpersona) | **GET** /v1/chat/workspace/{workspaceId}/member/{memberId}/persona | Get the Persona profile for this WorkspaceMember.
*ChatApi* | [**getPrivateNotes**](docs/Api/ChatApi.md#getprivatenotes) | **GET** /v1/chat/workspace/{workspaceId}/channel/{channelId}/notes | Get all private notes for a channel
*ChatApi* | [**getQuickReplies**](docs/Api/ChatApi.md#getquickreplies) | **GET** /v1/chat/workspace/{workspaceId}/{domainId}/quickreplies | Get quick replies for a workspace domain
*ChatApi* | [**getToken**](docs/Api/ChatApi.md#gettoken) | **GET** /v1/chat/workspace/{workspaceId}/token | Get an Ably (refresh) token. This token also includes the Users&#39; metadata (notifications) channel.
*ChatApi* | [**history**](docs/Api/ChatApi.md#history) | **GET** /v1/chat/workspace/{workspaceId}/channel/{channelId}/history | Gets all Messages of this Channel
*ChatApi* | [**participants**](docs/Api/ChatApi.md#participants) | **GET** /v1/chat/workspace/{workspaceId}/channel/{channelId}/participants | Gets all Participants of this Channel
*ChatApi* | [**removeParticipant**](docs/Api/ChatApi.md#removeparticipant) | **DELETE** /v1/chat/workspace/{workspaceId}/channel/{channelId}/participant/{personaId} | Remove a Chat Agent as a participant to this Channel.
*ChatApi* | [**updateChatClientPersona**](docs/Api/ChatApi.md#updatechatclientpersona) | **PATCH** /v1/chat/workspace/{workspaceId}/channel/{channelId}/persona/{personaId} | updates a ChatClientPersona profile.
*ChatApi* | [**updateName**](docs/Api/ChatApi.md#updatename) | **PATCH** /v1/chat/workspace/{workspaceId}/channel/{channelId}/name | Updates the name of this Channel
*ChatApi* | [**updateParticipantLastReadMessage**](docs/Api/ChatApi.md#updateparticipantlastreadmessage) | **PATCH** /v1/chat/workspace/{workspaceId}/channel/{channelId}/participant/{personaId}/lastReadMessage/{messageId} | Update a Participant&#39;s last read message in this Channel.
*ChatApi* | [**updatePersona**](docs/Api/ChatApi.md#updatepersona) | **PATCH** /v1/chat/workspace/{workspaceId}/member/{memberId}/persona | updates a ChatAgentPersona profile for the provided WorkspaceMember.
*ChatApi* | [**updatePrivateNote**](docs/Api/ChatApi.md#updateprivatenote) | **PATCH** /v1/chat/workspace/{workspaceId}/channel/{channelId}/note/{noteId} | Update the status of a private note
*ChatApi* | [**updateQuickReply**](docs/Api/ChatApi.md#updatequickreply) | **PATCH** /v1/chat/workspace/{workspaceId}/{domainId}/quickreply/{quickReplyId} | Create a quick reply
*ChatApi* | [**updateResolution**](docs/Api/ChatApi.md#updateresolution) | **PATCH** /v1/chat/workspace/{workspaceId}/channel/{channelId}/resolution | Updates the resolution of this Channel
*ChatApi* | [**updateStatus**](docs/Api/ChatApi.md#updatestatus) | **PATCH** /v1/chat/workspace/{workspaceId}/channel/{channelId}/status | Updates the status of this Channel
*ChatPublicApi* | [**createPublic**](docs/Api/ChatPublicApi.md#createpublic) | **POST** /v1/chat/public/channels/domain/{domainId} | Create a new Channel as a Client (starting point of a new Chat). This will also create a new Persona.
*ChatPublicApi* | [**getPublic**](docs/Api/ChatPublicApi.md#getpublic) | **GET** /v1/chat/public/channel/{channelId} | Retrieve an existing Channel as a Client
*ChatPublicApi* | [**getPublicToken**](docs/Api/ChatPublicApi.md#getpublictoken) | **GET** /v1/chat/public/channel/{channelId}/token | Get an Ably (refresh) token.
*ChatPublicApi* | [**historyPublic**](docs/Api/ChatPublicApi.md#historypublic) | **GET** /v1/chat/public/channel/{channelId}/history | Get history (all messages, participants/personas) for this channel
*ChatPublicApi* | [**isChannelAvailable**](docs/Api/ChatPublicApi.md#ischannelavailable) | **GET** /v1/chat/public/channels/available/{domainId} | Check if any agents are marked ONLINE to indicate Chat is available
*ConditionApi* | [**create**](docs/Api/ConditionApi.md#create) | **POST** /v1/condition | Create a new &#x60;Condition&#x60;.
*ConditionApi* | [**delete**](docs/Api/ConditionApi.md#delete) | **DELETE** /v1/condition/{conditionId} | Delete a &#x60;Condition&#x60;.
*ConditionApi* | [**get**](docs/Api/ConditionApi.md#get) | **GET** /v1/condition/{conditionId} | Get a &#x60;Condition&#x60; by its ID
*ConditionApi* | [**getAll**](docs/Api/ConditionApi.md#getall) | **GET** /v1/condition | Gets all &#x60;Condition&#x60;s for this User
*ConditionApi* | [**getButtons**](docs/Api/ConditionApi.md#getbuttons) | **GET** /v1/condition/button/{conditionId} | Get the &#x60;Button&#x60;s associated with this &#x60;Condition&#x60;
*ConditionApi* | [**update**](docs/Api/ConditionApi.md#update) | **PATCH** /v1/condition/{conditionId} | Update a &#x60;Condition&#x60;.
*DomainApi* | [**create**](docs/Api/DomainApi.md#create) | **POST** /v1/domain | Create a new &#x60;Domain&#x60;.
*DomainApi* | [**delete**](docs/Api/DomainApi.md#delete) | **DELETE** /v1/domain/{domainId} | Delete a &#x60;Domain&#x60;.
*DomainApi* | [**get**](docs/Api/DomainApi.md#get) | **GET** /v1/domain/{domainId} | Get a &#x60;Domain&#x60; by its ID
*DomainApi* | [**getAll**](docs/Api/DomainApi.md#getall) | **GET** /v1/domain | Get all &#x60;Domain&#x60;s
*DomainApi* | [**getByName**](docs/Api/DomainApi.md#getbyname) | **GET** /v1/domain/byName/{name} | Get a &#x60;Domain&#x60; by its name
*DomainApi* | [**update**](docs/Api/DomainApi.md#update) | **PATCH** /v1/domain/{domainId} | Update a &#x60;Domain&#x60;.
*DomainApi* | [**updateType**](docs/Api/DomainApi.md#updatetype) | **POST** /v1/domain/{domainId}/type/{type} | Update the type of a &#x60;Domain&#x60;. Only for PRO Accounts
*GoogleApi* | [**deleteAccount**](docs/Api/GoogleApi.md#deleteaccount) | **DELETE** /v1/google/workspace/{workspaceId}/account/{id} | Delete a Google account
*GoogleApi* | [**disableCalendarForPublic**](docs/Api/GoogleApi.md#disablecalendarforpublic) | **DELETE** /v1/google/calendar/workspace/{workspaceId}/account/{accountId}/calendar/{calendarId} | Disable a Google Calendar for public access
*GoogleApi* | [**enableCalendarForPublic**](docs/Api/GoogleApi.md#enablecalendarforpublic) | **POST** /v1/google/calendar/workspace/{workspaceId}/account/{accountId}/calendar/{calendarId} | Enable a Google Calendar for public access
*GoogleApi* | [**getAccount**](docs/Api/GoogleApi.md#getaccount) | **GET** /v1/google/workspace/{workspaceId}/account/{id} | Retrieve the current user&#39;s Google account
*GoogleApi* | [**getAccounts**](docs/Api/GoogleApi.md#getaccounts) | **GET** /v1/google/workspace/{workspaceId}/accounts | Retrieve all the current user&#39;s coupled Google accounts
*GoogleApi* | [**getAllCalendars**](docs/Api/GoogleApi.md#getallcalendars) | **GET** /v1/google/calendar/workspace/{workspaceId}/all/calendars | Retrieve all Google Calendars for the current user
*GoogleApi* | [**getAllCalendarsForAccount**](docs/Api/GoogleApi.md#getallcalendarsforaccount) | **GET** /v1/google/calendar/workspace/{workspaceId}/account/{accountId}/calendars | Retrieve all Calendars for a single Google Account
*GoogleApi* | [**getAllEvents**](docs/Api/GoogleApi.md#getallevents) | **GET** /v1/google/calendar/workspace/{workspaceId}/all/events | Retrieve all events from all Google Calendars
*GoogleApi* | [**getAllEventsForCalendar**](docs/Api/GoogleApi.md#getalleventsforcalendar) | **GET** /v1/google/calendar/workspace/{workspaceId}/account/{accountId}/calendar/{calendarId}/events | Retrieve all events for a single Google Calendar
*GoogleApi* | [**getEvent**](docs/Api/GoogleApi.md#getevent) | **GET** /v1/google/calendar/workspace/{workspaceId}/account/{accountId}/calendar/{calendarId}/event/{id} | Retrieve a specific Google Calendar event by ID
*GoogleApi* | [**handleDirectOAuthCallback**](docs/Api/GoogleApi.md#handledirectoauthcallback) | **GET** /v1/google/oauth2/callback | Handle direct OAuth callback from Google
*GoogleApi* | [**initiateOAuthFlow**](docs/Api/GoogleApi.md#initiateoauthflow) | **GET** /v1/google/workspace/{workspaceId}/oauth2/authorize | Initiate OAuth flow for Google Calendar
*GoogleApi* | [**syncCalendars**](docs/Api/GoogleApi.md#synccalendars) | **POST** /v1/google/calendar/workspace/{workspaceId}/account/{accountId}/calendars/sync | Synchronize calendars from Google to local database
*GoogleApi* | [**updateEvent**](docs/Api/GoogleApi.md#updateevent) | **POST** /v1/google/calendar/workspace/{workspaceId}/account/{accountId}/calendar/{calendarId}/event/{id} | Update a Google Calendar event
*MagicTokenApi* | [**consume**](docs/Api/MagicTokenApi.md#consume) | **PATCH** /v1/magic-token/{id} | Marks a Magic token as used/consumed.
*MagicTokenApi* | [**create**](docs/Api/MagicTokenApi.md#create) | **POST** /v1/magic-token | Create a new Magic Token.         This endpoint is used for API (authenticated) users.         For unauthenticated users, use the /email (requestNewToken) endpoint.
*MagicTokenApi* | [**exchange**](docs/Api/MagicTokenApi.md#exchange) | **GET** /auth/magic-token/{token} | Exchange a magic token for an authenticated cookie (and redirect if possible).
*MagicTokenApi* | [**get**](docs/Api/MagicTokenApi.md#get) | **GET** /v1/magic-token/{id} | Return a MagicToken by its ID, without the actual token.
*MagicTokenApi* | [**getAll**](docs/Api/MagicTokenApi.md#getall) | **GET** /v1/magic-token | Return all MagicToken defined for this user, without the actual token.
*MagicTokenApi* | [**requestNewToken**](docs/Api/MagicTokenApi.md#requestnewtoken) | **POST** /v1/magic-token/email | Request a Magic Token via e-mail.
*MediaApi* | [**create**](docs/Api/MediaApi.md#create) | **POST** /v1/user/media | Upload a new file
*MediaApi* | [**delete**](docs/Api/MediaApi.md#delete) | **DELETE** /v1/user/media/{id} | Delete a file
*MediaApi* | [**get**](docs/Api/MediaApi.md#get) | **GET** /v1/user/media/{id} | Get media by id
*MediaApi* | [**getAll**](docs/Api/MediaApi.md#getall) | **GET** /v1/user/media | Get all media
*MediaApi* | [**getUsage**](docs/Api/MediaApi.md#getusage) | **GET** /v1/user/media/usage | Get usage (total bytes used by user)
*MediaApi* | [**update**](docs/Api/MediaApi.md#update) | **PUT** /v1/user/media/{id} | Update a file. Does not update metadata.
*MediaApi* | [**updateMetadata**](docs/Api/MediaApi.md#updatemetadata) | **PATCH** /v1/user/media/{id} | Update metadata for a file. Does not modify original file.
*MeetApi* | [**createMeeting**](docs/Api/MeetApi.md#createmeeting) | **POST** /v1/meet/workspace/{workspaceId}/domain/{domainId}/meeting | Create a new meeting
*MeetApi* | [**deleteMeeting**](docs/Api/MeetApi.md#deletemeeting) | **DELETE** /v1/meet/workspace/{workspaceId}/domain/{domainId}/meeting/{meetingId} | Delete a meeting
*MeetApi* | [**disableMeeting**](docs/Api/MeetApi.md#disablemeeting) | **PATCH** /v1/meet/workspace/{workspaceId}/domain/{domainId}/meeting/{meetingId}/disable | 
*MeetApi* | [**enableMeeting**](docs/Api/MeetApi.md#enablemeeting) | **PATCH** /v1/meet/workspace/{workspaceId}/domain/{domainId}/meeting/{meetingId}/enable | 
*MeetApi* | [**getAllMeetings**](docs/Api/MeetApi.md#getallmeetings) | **GET** /v1/meet/workspace/{workspaceId}/meetings | Retrieve all meetings for the current user
*MeetApi* | [**getMeeting**](docs/Api/MeetApi.md#getmeeting) | **GET** /v1/meet/workspace/{workspaceId}/domain/{domainId}/meeting{meetingId} | Retrieve a specific meeting by ID
*MeetApi* | [**updateMeeting**](docs/Api/MeetApi.md#updatemeeting) | **PATCH** /v1/meet/workspace/{workspaceId}/domain/{domainId}/meeting/{meetingId} | Update a meeting&#39;s strategy configuration
*MeetApi* | [**updateMeetingFields**](docs/Api/MeetApi.md#updatemeetingfields) | **PATCH** /v1/meet/workspace/{workspaceId}/domain/{domainId}/meeting/{meetingId}/fields | Replace meeting fields
*MeetPublicApi* | [**claimAvailableSlot**](docs/Api/MeetPublicApi.md#claimavailableslot) | **POST** /v1/meet/public/{workspaceSlug}/{meetId}/available-slot/{slotId} | Claim an available slot for this account
*MeetPublicApi* | [**getAvailableSlot**](docs/Api/MeetPublicApi.md#getavailableslot) | **GET** /v1/meet/public/{workspaceSlug}/{meetId}/slot/{slotId} | Get details on a single available slot
*MeetPublicApi* | [**getAvailableSlots**](docs/Api/MeetPublicApi.md#getavailableslots) | **GET** /v1/meet/public/{workspaceSlug}/{meetId}/available-slots | Get all available slots for this account
*MeetPublicApi* | [**getBookedSlot**](docs/Api/MeetPublicApi.md#getbookedslot) | **GET** /v1/meet/public/{workspaceSlug}/{meetId}/booked-slot/{confirmationId} | Return information about the already booked slot
*MeetPublicApi* | [**getFields**](docs/Api/MeetPublicApi.md#getfields) | **GET** /v1/meet/public/{workspaceSlug}/{meetId}/fields | Get all available slots for this account
*MeetPublicApi* | [**getIcsForBookedSlot**](docs/Api/MeetPublicApi.md#geticsforbookedslot) | **GET** /v1/meet/public/{workspaceSlug}/{meetId}/booked-slot/{confirmationId}.ics | Get the ICS for an already booked slot
*MeetPublicApi* | [**getIcsForBookedSlotUrlEndpoint**](docs/Api/MeetPublicApi.md#geticsforbookedsloturlendpoint) | **GET** /v1/meet/public/{workspaceSlug}/{meetId}/booked-slot/{confirmationId}/ics | Get the ICS URL endpoint for an already booked slot. This points to the public #getIcsForBookedSlot endpoint
*MeetPublicApi* | [**isValid**](docs/Api/MeetPublicApi.md#isvalid) | **GET** /v1/meet/public/{workspaceSlug}/{meetId}/validation/{domainName} | Check if this domain is valid for this meeting
*SettingsApi* | [**getSettingsForUserId**](docs/Api/SettingsApi.md#getsettingsforuserid) | **GET** /v1/settings/{userId} | Get the JS Snippet for all domains of this User.
*SettingsApi* | [**getSettingsForUserIdAndDomainId**](docs/Api/SettingsApi.md#getsettingsforuseridanddomainid) | **GET** /v1/settings/{userId}/{domainId} | Get the JS Snippet for this Domain.
*SettingsApi* | [**getSettingsForUserIdAndDomainIdJs**](docs/Api/SettingsApi.md#getsettingsforuseridanddomainidjs) | **GET** /v1/settings/{userId}/{domainId}/js | Get the JS Snippet for this Domain, including appending to &lt;head&gt;.
*SettingsApi* | [**getSettingsForUserIdJs**](docs/Api/SettingsApi.md#getsettingsforuseridjs) | **GET** /v1/settings/{userId}/js | Get the JS Snippet for all domains of this User, including appending to &lt;head&gt;.
*SettingsApi* | [**getSettingsJsonForDomain**](docs/Api/SettingsApi.md#getsettingsjsonfordomain) | **GET** /v1/settings/{userId}/{domainId}/json | Get the Settings for this Domain.
*SettingsApi* | [**getSettingsJsonForUser**](docs/Api/SettingsApi.md#getsettingsjsonforuser) | **GET** /v1/settings/{userId}/json | Get the Settings for all domains of this User.
*StripeApi* | [**createBillingPortal**](docs/Api/StripeApi.md#createbillingportal) | **POST** /v1/stripe/createBillingPortal | Create a Stripe Billing Portal
*StripeApi* | [**getAll**](docs/Api/StripeApi.md#getall) | **GET** /v1/stripe/plans | Get all available plans
*StripeApi* | [**getAllAgencyPlans**](docs/Api/StripeApi.md#getallagencyplans) | **GET** /v1/stripe/agencyPlans | Get all available Agency plans
*StripeApi* | [**getCoupon**](docs/Api/StripeApi.md#getcoupon) | **GET** /v1/stripe/coupons/wp | Get the currently active/available Coupon
*StripeApi* | [**requestBillingPortal**](docs/Api/StripeApi.md#requestbillingportal) | **POST** /v1/stripe/requestBillingPortal | Create a Stripe Billing Portal
*SubscriptionApi* | [**createCheckoutSession**](docs/Api/SubscriptionApi.md#createcheckoutsession) | **POST** /v1/subscription/v2 | Create a Stripe Checkout session. Default is a redirect to the Hosted Checkout Page.
*SubscriptionApi* | [**createProAccountCheckoutSession**](docs/Api/SubscriptionApi.md#createproaccountcheckoutsession) | **POST** /v1/subscription/proAccount | Create a Stripe Checkout session for a PRO Account. Default is a redirect to the Hosted Checkout Page.
*SubscriptionApi* | [**getCheckoutSession**](docs/Api/SubscriptionApi.md#getcheckoutsession) | **GET** /v1/subscription/session/{checkoutSessionId} | Get a Stripe Checkout session
*SubscriptionApi* | [**getSubscriptionStatusForDomain**](docs/Api/SubscriptionApi.md#getsubscriptionstatusfordomain) | **GET** /v1/subscription/domain/{domainId} | Get subscription status for a domain
*UserApi* | [**createUser**](docs/Api/UserApi.md#createuser) | **POST** /v1/user | Create a new user.
*UserApi* | [**deleteUser**](docs/Api/UserApi.md#deleteuser) | **DELETE** /v1/user | Deletes the currently logged in &#x60;User
*UserApi* | [**enableEmailOptInPreference**](docs/Api/UserApi.md#enableemailoptinpreference) | **POST** /v1/user/emailPreference | Set the email opt-in to true for this &#x60;User&#x60;
*UserApi* | [**getStripeDetails**](docs/Api/UserApi.md#getstripedetails) | **GET** /v1/user/payment-details | Retrieve payment details for the current user.
*UserApi* | [**getUser**](docs/Api/UserApi.md#getuser) | **GET** /v1/user | Retrieve the current (logged in) user.
*UserApi* | [**login**](docs/Api/UserApi.md#login) | **POST** /v1/session | Login the current user via a form.
*UserApi* | [**logout**](docs/Api/UserApi.md#logout) | **POST** /v1/logout | Logout.
*UserApi* | [**removeEmailOptInPreference**](docs/Api/UserApi.md#removeemailoptinpreference) | **DELETE** /v1/user/emailPreference | Set the email opt-in to false for this &#x60;User&#x60;
*UserApi* | [**requestPasswordReset**](docs/Api/UserApi.md#requestpasswordreset) | **GET** /v1/user/password-reset | Allows a &#x60;User&#x60; to request a (short-lived) token. This will be send via e-mail.
*UserApi* | [**resetPassword**](docs/Api/UserApi.md#resetpassword) | **POST** /v1/user/password-reset | Allows a &#x60;User&#x60; to reset their password via a (short-lived) token.
*UserApi* | [**setStorageSettings**](docs/Api/UserApi.md#setstoragesettings) | **POST** /v1/user/settings/storage/{implementation} | Switch the user storage platform to a different one (either GCP (Google) or R2 (Cloudflare).
*UserApi* | [**updatePassword**](docs/Api/UserApi.md#updatepassword) | **PATCH** /v1/user/update-password | Update the password for a logged in &#x60;User
*UserApi* | [**updateUser**](docs/Api/UserApi.md#updateuser) | **PATCH** /v1/user | Update a user. Currently only &#x60;name&#x60; can be updated.
*UserApi* | [**upgradeSubscriptionToYearly**](docs/Api/UserApi.md#upgradesubscriptiontoyearly) | **POST** /v1/user/subscription/{subscriptionId}/upgrade-to-yearly | Upgrade a subscription from monthly to yearly billing
*UserApi* | [**wordPressSignup**](docs/Api/UserApi.md#wordpresssignup) | **POST** /v1/user/wp | Create a &#x60;User&#x60; from a WordPress signup.
*WordPressApi* | [**getDomain**](docs/Api/WordPressApi.md#getdomain) | **GET** /v1/wp/all/{domainName} | Get all WordPress specific information
*WorkspaceApi* | [**addDomain**](docs/Api/WorkspaceApi.md#adddomain) | **POST** /v1/workspace/{workspaceId}/domain/{domainId} | Add an existing &#x60;Domain&#x60; to an &#x60;Workspace&#x60;.
*WorkspaceApi* | [**addDomainPermission**](docs/Api/WorkspaceApi.md#adddomainpermission) | **POST** /v1/workspace/{workspaceId}/domain/{domainId}/permissions | Add Permission to a Member for a Workspace.
*WorkspaceApi* | [**addMember**](docs/Api/WorkspaceApi.md#addmember) | **POST** /v1/workspace/{workspaceId}/members | Add a (new) &#x60;User&#x60; as a Member to a Workspace.
*WorkspaceApi* | [**create**](docs/Api/WorkspaceApi.md#create) | **POST** /v1/workspace | Create a workspace.
*WorkspaceApi* | [**delete**](docs/Api/WorkspaceApi.md#delete) | **DELETE** /v1/workspace/{workspaceId} | Deletes a workspace.
*WorkspaceApi* | [**get**](docs/Api/WorkspaceApi.md#get) | **GET** /v1/workspace/{workspaceId} | Retrieve a single &#x60;Workspace&#x60; by ID
*WorkspaceApi* | [**getAll**](docs/Api/WorkspaceApi.md#getall) | **GET** /v1/workspace | Retrieve all workspaces for this user.
*WorkspaceApi* | [**getAvailableDomains**](docs/Api/WorkspaceApi.md#getavailabledomains) | **GET** /v1/workspace/{workspaceId}/domains/available | List all potentially available &#x60;Domain&#x60;s for an &#x60;Workspace&#x60;.
*WorkspaceApi* | [**leave**](docs/Api/WorkspaceApi.md#leave) | **DELETE** /v1/workspace/{workspaceId}/member/self | Leave a Workspace. This is useful for an Agent, to remove themselves from a Workspace.
*WorkspaceApi* | [**removeDomain**](docs/Api/WorkspaceApi.md#removedomain) | **DELETE** /v1/workspace/{workspaceId}/domain/{domainId} | Remove a &#x60;Domain&#x60; association from a &#x60;Workspace&#x60;.
*WorkspaceApi* | [**removeDomainPermission**](docs/Api/WorkspaceApi.md#removedomainpermission) | **DELETE** /v1/workspace/{workspaceId}/domain/{domainId}/permission/{permissionId} | Remove Permission from a Member for a Workspace.
*WorkspaceApi* | [**removeMember**](docs/Api/WorkspaceApi.md#removemember) | **DELETE** /v1/workspace/{workspaceId}/member/{memberId} | Remove a Member from a Workspace.
*WorkspaceApi* | [**update**](docs/Api/WorkspaceApi.md#update) | **PATCH** /v1/workspace/{workspaceId} | Update a workspace.
*WorkspaceApi* | [**updateDomainOptions**](docs/Api/WorkspaceApi.md#updatedomainoptions) | **PATCH** /v1/workspace/{workspaceId}/domain/{domainId}/options | Modify the options on a Domain for a Workspace.

## Models

- [AblyChatMessage](docs/Model/AblyChatMessage.md)
- [Action](docs/Model/Action.md)
- [ActionCreateRequest](docs/Model/ActionCreateRequest.md)
- [ActionDeleteResponse](docs/Model/ActionDeleteResponse.md)
- [ActionSchedule](docs/Model/ActionSchedule.md)
- [ActionUpdateRequest](docs/Model/ActionUpdateRequest.md)
- [Address](docs/Model/Address.md)
- [ApiServerException](docs/Model/ApiServerException.md)
- [ApiServerExceptionResponse](docs/Model/ApiServerExceptionResponse.md)
- [ApiServerExceptionWithErrorCode](docs/Model/ApiServerExceptionWithErrorCode.md)
- [Apikey](docs/Model/Apikey.md)
- [ApikeyCreateRequest](docs/Model/ApikeyCreateRequest.md)
- [ApikeyDeleteResponse](docs/Model/ApikeyDeleteResponse.md)
- [ApikeyUpdateRequest](docs/Model/ApikeyUpdateRequest.md)
- [ApikeyWithKey](docs/Model/ApikeyWithKey.md)
- [AppointmentSlot](docs/Model/AppointmentSlot.md)
- [Auth](docs/Model/Auth.md)
- [AvailabilityWindow](docs/Model/AvailabilityWindow.md)
- [AvailableDomainsResponse](docs/Model/AvailableDomainsResponse.md)
- [AvailableSlotResponse](docs/Model/AvailableSlotResponse.md)
- [AvailableSlotsResponse](docs/Model/AvailableSlotsResponse.md)
- [BookedAppointment](docs/Model/BookedAppointment.md)
- [Button](docs/Model/Button.md)
- [ButtonCreateRequest](docs/Model/ButtonCreateRequest.md)
- [ButtonCreateRequestV2](docs/Model/ButtonCreateRequestV2.md)
- [ButtonMinimal](docs/Model/ButtonMinimal.md)
- [ButtonOptions](docs/Model/ButtonOptions.md)
- [ButtonUpdateRequest](docs/Model/ButtonUpdateRequest.md)
- [ButtonUpdateRequestV2](docs/Model/ButtonUpdateRequestV2.md)
- [CalendarBasedStrategyConfig](docs/Model/CalendarBasedStrategyConfig.md)
- [ChannelAvailableResponse](docs/Model/ChannelAvailableResponse.md)
- [ChatAgentAddRequest](docs/Model/ChatAgentAddRequest.md)
- [ChatAgentPersona](docs/Model/ChatAgentPersona.md)
- [ChatChannel](docs/Model/ChatChannel.md)
- [ChatChannelCreateRequest](docs/Model/ChatChannelCreateRequest.md)
- [ChatChannelCreateResponse](docs/Model/ChatChannelCreateResponse.md)
- [ChatChannelEvent](docs/Model/ChatChannelEvent.md)
- [ChatChannelFull](docs/Model/ChatChannelFull.md)
- [ChatChannelNameUpdateRequest](docs/Model/ChatChannelNameUpdateRequest.md)
- [ChatChannelResolutionUpdateRequest](docs/Model/ChatChannelResolutionUpdateRequest.md)
- [ChatChannelStatusUpdateRequest](docs/Model/ChatChannelStatusUpdateRequest.md)
- [ChatClientPersona](docs/Model/ChatClientPersona.md)
- [ChatClientPersonaUpdateRequest](docs/Model/ChatClientPersonaUpdateRequest.md)
- [ChatMessage](docs/Model/ChatMessage.md)
- [ChatUserCreateRequest](docs/Model/ChatUserCreateRequest.md)
- [ChatUserUpdateRequest](docs/Model/ChatUserUpdateRequest.md)
- [ChatWorkspaceDomainPersona](docs/Model/ChatWorkspaceDomainPersona.md)
- [CheckoutSessionCreateRequest](docs/Model/CheckoutSessionCreateRequest.md)
- [CheckoutSessionResponse](docs/Model/CheckoutSessionResponse.md)
- [CheckoutSessionStatusResponse](docs/Model/CheckoutSessionStatusResponse.md)
- [ClientAction](docs/Model/ClientAction.md)
- [CnbMarketingData](docs/Model/CnbMarketingData.md)
- [CnbPromotionCodeRestrictions](docs/Model/CnbPromotionCodeRestrictions.md)
- [Condition](docs/Model/Condition.md)
- [ConditionCreateRequest](docs/Model/ConditionCreateRequest.md)
- [ConditionDeleteResponse](docs/Model/ConditionDeleteResponse.md)
- [ConditionUpdateRequest](docs/Model/ConditionUpdateRequest.md)
- [ConfigurationBasedStrategyConfig](docs/Model/ConfigurationBasedStrategyConfig.md)
- [CopyButtonRequest](docs/Model/CopyButtonRequest.md)
- [CopyButtonResponse](docs/Model/CopyButtonResponse.md)
- [CreateMeetingRequest](docs/Model/CreateMeetingRequest.md)
- [CreateQuickReplyRequest](docs/Model/CreateQuickReplyRequest.md)
- [DeleteButtonResponse](docs/Model/DeleteButtonResponse.md)
- [DeleteQuickReplyResponse](docs/Model/DeleteQuickReplyResponse.md)
- [DeleteWorkspaceResponse](docs/Model/DeleteWorkspaceResponse.md)
- [Domain](docs/Model/Domain.md)
- [DomainCreateRequest](docs/Model/DomainCreateRequest.md)
- [DomainDeleteResponse](docs/Model/DomainDeleteResponse.md)
- [DomainMinimal](docs/Model/DomainMinimal.md)
- [DomainUpdateRequest](docs/Model/DomainUpdateRequest.md)
- [ErrorCode](docs/Model/ErrorCode.md)
- [EventUpdateData](docs/Model/EventUpdateData.md)
- [ExportButtonRequest](docs/Model/ExportButtonRequest.md)
- [ExportButtonResponse](docs/Model/ExportButtonResponse.md)
- [Field](docs/Model/Field.md)
- [FieldRequest](docs/Model/FieldRequest.md)
- [GoogleAccount](docs/Model/GoogleAccount.md)
- [GoogleAccountProfile](docs/Model/GoogleAccountProfile.md)
- [GoogleCalendar](docs/Model/GoogleCalendar.md)
- [GoogleCalendarEvent](docs/Model/GoogleCalendarEvent.md)
- [HistoryResponse](docs/Model/HistoryResponse.md)
- [ImportButtonRequest](docs/Model/ImportButtonRequest.md)
- [ImportButtonResponse](docs/Model/ImportButtonResponse.md)
- [ImportDomain](docs/Model/ImportDomain.md)
- [LoginResponse](docs/Model/LoginResponse.md)
- [MagicToken](docs/Model/MagicToken.md)
- [MagicTokenAnonymousRequest](docs/Model/MagicTokenAnonymousRequest.md)
- [MagicTokenRequest](docs/Model/MagicTokenRequest.md)
- [MagicTokenResponse](docs/Model/MagicTokenResponse.md)
- [Media](docs/Model/Media.md)
- [MediaDeleteResponse](docs/Model/MediaDeleteResponse.md)
- [MediaMinimal](docs/Model/MediaMinimal.md)
- [MediaUpdateMetadataRequest](docs/Model/MediaUpdateMetadataRequest.md)
- [MediaUsageResponse](docs/Model/MediaUsageResponse.md)
- [Meeting](docs/Model/Meeting.md)
- [MeetingStrategy](docs/Model/MeetingStrategy.md)
- [MemberAddRequest](docs/Model/MemberAddRequest.md)
- [MetaChannelMessage](docs/Model/MetaChannelMessage.md)
- [MultiButtonOptions](docs/Model/MultiButtonOptions.md)
- [OauthFlowResult](docs/Model/OauthFlowResult.md)
- [Options](docs/Model/Options.md)
- [Participant](docs/Model/Participant.md)
- [PasswordResetResponse](docs/Model/PasswordResetResponse.md)
- [PasswordResetSuccessResponse](docs/Model/PasswordResetSuccessResponse.md)
- [Permission](docs/Model/Permission.md)
- [PermissionAddRequest](docs/Model/PermissionAddRequest.md)
- [Persona](docs/Model/Persona.md)
- [PresenceUpdate](docs/Model/PresenceUpdate.md)
- [PrivateNote](docs/Model/PrivateNote.md)
- [PrivateNoteRequest](docs/Model/PrivateNoteRequest.md)
- [ProAccountCheckoutSessionCreateRequest](docs/Model/ProAccountCheckoutSessionCreateRequest.md)
- [ProAccountCheckoutSessionResponse](docs/Model/ProAccountCheckoutSessionResponse.md)
- [PromotionCode](docs/Model/PromotionCode.md)
- [QuickReply](docs/Model/QuickReply.md)
- [RequestBillingPortalResponse](docs/Model/RequestBillingPortalResponse.md)
- [SchedulingStrategyConfig](docs/Model/SchedulingStrategyConfig.md)
- [ScrollOptions](docs/Model/ScrollOptions.md)
- [Session](docs/Model/Session.md)
- [Settings](docs/Model/Settings.md)
- [SettingsAction](docs/Model/SettingsAction.md)
- [SettingsButton](docs/Model/SettingsButton.md)
- [SettingsCondition](docs/Model/SettingsCondition.md)
- [SettingsDomain](docs/Model/SettingsDomain.md)
- [SettingsOptions](docs/Model/SettingsOptions.md)
- [SlotClaim](docs/Model/SlotClaim.md)
- [SlotClaimResponse](docs/Model/SlotClaimResponse.md)
- [SlotFields](docs/Model/SlotFields.md)
- [StripeAgencyPlan](docs/Model/StripeAgencyPlan.md)
- [StripeAgencyPlanPrice](docs/Model/StripeAgencyPlanPrice.md)
- [StripeBillingPortal](docs/Model/StripeBillingPortal.md)
- [StripeBillingPortalConfiguration](docs/Model/StripeBillingPortalConfiguration.md)
- [StripeDetails](docs/Model/StripeDetails.md)
- [StripePaymentDetails](docs/Model/StripePaymentDetails.md)
- [StripePlan](docs/Model/StripePlan.md)
- [SubscriptionSafe](docs/Model/SubscriptionSafe.md)
- [SubscriptionStatusData](docs/Model/SubscriptionStatusData.md)
- [SubscriptionUpgradeResponse](docs/Model/SubscriptionUpgradeResponse.md)
- [TaxId](docs/Model/TaxId.md)
- [TokenRequest](docs/Model/TokenRequest.md)
- [UpdateFieldsRequest](docs/Model/UpdateFieldsRequest.md)
- [UpdateMeetingRequest](docs/Model/UpdateMeetingRequest.md)
- [UpdateMeetingRequestStrategy](docs/Model/UpdateMeetingRequestStrategy.md)
- [UpdatePrivateNoteRequest](docs/Model/UpdatePrivateNoteRequest.md)
- [User](docs/Model/User.md)
- [UserCreateRequest](docs/Model/UserCreateRequest.md)
- [UserModifiedResponse](docs/Model/UserModifiedResponse.md)
- [UserSettings](docs/Model/UserSettings.md)
- [UserUpdateRequest](docs/Model/UserUpdateRequest.md)
- [ValidResponse](docs/Model/ValidResponse.md)
- [Validation](docs/Model/Validation.md)
- [ValidationResult](docs/Model/ValidationResult.md)
- [Verification](docs/Model/Verification.md)
- [WordPressInfo](docs/Model/WordPressInfo.md)
- [WordPressSignupCreateRequest](docs/Model/WordPressSignupCreateRequest.md)
- [Workspace](docs/Model/Workspace.md)
- [WorkspaceCreateRequest](docs/Model/WorkspaceCreateRequest.md)
- [WorkspaceDomainPersonaCreateRequest](docs/Model/WorkspaceDomainPersonaCreateRequest.md)
- [WorkspaceOptionsUpdateRequest](docs/Model/WorkspaceOptionsUpdateRequest.md)
- [WorkspacePersona](docs/Model/WorkspacePersona.md)
- [WorkspaceUpdateRequest](docs/Model/WorkspaceUpdateRequest.md)
- [WsDomain](docs/Model/WsDomain.md)
- [WsMember](docs/Model/WsMember.md)

## Authorization

Authentication schemes defined for the API:
### sessionCookieScheme

- **Type**: API key
- **API key parameter name**: SESSION
- **Location**: 


### apikeyScheme

- **Type**: API key
- **API key parameter name**: x-cnb-api-key
- **Location**: HTTP header


## Tests

To run the tests, use:

```bash
composer install
vendor/bin/phpunit
```

## Author

support@nowbuttons.com

## About this package

This PHP package is automatically generated by the [OpenAPI Generator](https://openapi-generator.tech) project:

- API version: `0.0.219-local`
    - Generator version: `7.12.0`
- Build package: `org.openapitools.codegen.languages.PhpClientCodegen`
