@php
function slugify($text, string $divider = '-')
{
// replace non letter or digits by divider
$text = preg_replace('~[^\pL\d]+~u', $divider, $text);

// transliterate
$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

// remove unwanted characters
$text = preg_replace('~[^-\w]+~', '', $text);

// trim
$text = trim($text, $divider);

// remove duplicate divider
$text = preg_replace('~-+~', $divider, $text);

// lowercase
$text = strtolower($text);

if (empty($text)) {
return 'n-a';
}

return $text;
}
@endphp

<body>
    <div id="meet" style="height:100vh;width:100%"></div>
</body>

<script src='https://meet.jit.si/external_api.js'></script>

<script>
    const domain = 'meet.jit.si';
    const options = {
        roomName: '{{slugify(request("roomname"))}}',
        parentNode: document.querySelector('#meet'),
        userInfo: {
            email: '{{request("email")}}',
            displayName: '{{request("displayName")}}'
        },
        lang: 'fr',

        configOverwrite: {
            disableDeepLinking: true
        },
        interfaceConfigOverwrite: {
            SHOW_CHROME_EXTENSION_BANNER: false,
            SHOW_PROMOTIONAL_CLOSE_PAGE: false,
            SHOW_POWERED_BY: false,
            SHOW_BRAND_WATERMARK: false,
            filmStripOnly: false,


            MOBILE_APP_PROMO: true,
            SHOW_BRAND_WATERMARK: false,
            SHOW_JITSI_WATERMARK: false,
            SHOW_WATERMARK_FOR_GUESTS: false,
            SHOW_POWERED_BY: false,



            TOOLBAR_BUTTONS: [
                'camera',
                'microphone',
                'fullscreen',
                // 'hangup',
                'profile',
                'chat',
                'settings',
                'videoquality',
                'desktop',
                'tileview',
                'raisehand',
                'videobackgroundblur',
                'sharedvideo',
            ],
            DISABLE_JOIN_LEAVE_NOTIFICATIONS: true,
            SETTINGS_SECTIONS: ['devices', 'language', 'moderator', 'profile', 'calendar'],
            DISABLE_JOIN_LEAVE_NOTIFICATIONS: true,
        },
    };

    window.onload = () => {
        const api = new JitsiMeetExternalAPI(domain, options);
        //Display name
        api.executeCommand('displayName', '{{request("displayName")}}');
        api.executeCommand('joinBreakoutRoom');
        //Meeting name
        api.executeCommand('subject', '{{request("roomname")}}');
        //Allow this user to control the lobby
        api.addEventListener('participantRoleChanged', function(event) {
            if (event.role === 'moderator') {
                api.executeCommand('toggleLobby', true);
            }
        });

        //keep this same to display
        api.addEventListener('readyToClose', function() {
            api.dispose();
            window.location.href = '{{request("callback")}}';
        });

    }
    //
</script>