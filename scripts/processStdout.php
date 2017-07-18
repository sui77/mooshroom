<?php

$p = '<table class="wikitable" data-description="Server properties" style="max-width: 100%;">

<tr>
<th><span style="white-space:nowrap;"><b>allow-flight</b></span></th>
<td>boolean</td>
<td>false</td>
<td><span id="allow-flight"></span>Allows users to use flight on your server while in Survival mode, if they have a <a href="/Mod" title="Mod" class="mw-redirect">mod</a> that provides flight installed.
<p>With allow-flight enabled, <a href="/Griefers" title="Griefers" class="mw-redirect">griefers</a> will possibly be more common, because it will make their work easier. In Creative mode this has no effect.</p>
<dl>
<dd><b>false</b> - Flight is not allowed (players in air for at least 5 seconds will be kicked).</dd>
<dd><b>true</b> - Flight is allowed, and used if the player has a fly mod installed.</dd>
</dl>
</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>allow-nether</b></span></th>
<td>boolean</td>
<td>true</td>
<td><span id="allow-nether"></span>Allows players to travel to the <a href="/Nether" title="Nether">Nether</a>.
<dl>
<dd><b>false</b> - <a href="/Nether" title="Nether">Nether</a> portals will not work.</dd>
<dd><b>true</b> - The server will allow <a href="/Portal" title="Portal">portals</a> to send players to the Nether.</dd>
</dl>
</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>announce-player-achievements</b></span></th>
<td>boolean</td>
<td>true</td>
<td><span id="announce-player-achievements"></span>Allows server to announce when a player gets an <a href="/Achievement" title="Achievement" class="mw-redirect">achievement</a>.</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>difficulty</b></span></th>
<td>integer (0-3)</td>
<td>1</td>
<td><span id="difficulty"></span>Defines the <a href="/Difficulty" title="Difficulty">difficulty</a> (such as damage dealt by mobs and the way hunger and poison affects players) of the server.
<dl>
<dd><b>0</b> - Peaceful</dd>
<dd><b>1</b> - Easy</dd>
<dd><b>2</b> - Normal</dd>
<dd><b>3</b> - Hard</dd>
</dl>
</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>enable-query</b></span></th>
<td>boolean</td>
<td>false</td>
<td><span id="enable-query"></span>Enables GameSpy4 protocol server listener. Used to get information about server.</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>enable-rcon</b></span></th>
<td>boolean</td>
<td>false</td>
<td><span id="enable-rcon"></span>Enables remote access to the server console.</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>enable-command-block</b></span></th>
<td>boolean</td>
<td>false</td>
<td><span id="enable-command-block"></span>Enables command blocks</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>force-gamemode</b></span></th>
<td>boolean</td>
<td>false</td>
<td><span id="force-gamemode"></span>Force players to join in the default <a href="/Game_mode" title="Game mode" class="mw-redirect">game mode</a>.
<dl>
<dd><b>false</b> - Players will join in the gamemode they left in.</dd>
<dd><b>true</b> - Players will always join in the default gamemode.</dd>
</dl>
</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>gamemode</b></span></th>
<td>integer (0-3)</td>
<td>0</td>
<td><span id="gamemode"></span>Defines the <a href="/Game_mode" title="Game mode" class="mw-redirect">mode of gameplay</a>.
<dl>
<dd><b>0</b> - Survival</dd>
<dd><b>1</b> - Creative</dd>
<dd><b>2</b> - Adventure</dd>
<dd><b>3</b> - Spectator</dd>
</dl>
</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>generate-structures</b></span></th>
<td>boolean</td>
<td>true</td>
<td><span id="generate-structures"></span>Defines whether <a href="/Structures" title="Structures" class="mw-redirect">structures</a> (such as villages) will be generated.
<dl>
<dd><b>false</b> - Structures will not be generated in new chunks.</dd>
<dd><b>true</b> - Structures will be generated in new chunks.</dd>
</dl>
<p><b>Note:</b> <i>Dungeons will still generate if this is set to false.</i></p>
</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>generator-settings</b></span></th>
<td>string</td>
<td><i>blank</i></td>
<td><span id="generator-settings"></span>The settings used to customize world generation. See <a href="/Superflat" title="Superflat">Superflat</a> and <a href="/Customized" title="Customized">Customized</a> for possible settings and examples.</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>hardcore</b></span></th>
<td>boolean</td>
<td>false</td>
<td><span id="hardcore"></span>If set to <b>true</b>, players will be set to spectator mode if they die.</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>level-name</b></span></th>
<td>string</td>
<td>world</td>
<td><span id="level-name"></span>The "level-name" value will be used as the world name and its folder name. You may also copy your saved game folder here, and change the name to the same as that folder\'s to load it instead.
<dl>
<dd>Characters such as \' (apostrophe) may need to be escaped by adding a backslash before them.</dd>
</dl>
</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>level-seed</b></span></th>
<td>string</td>
<td><i>blank</i></td>
<td><span id="level-seed"></span>Add a <a href="/Seed_(Level_Generation)" title="Seed (Level Generation)" class="mw-redirect">seed</a> for your world, as in Singleplayer.
<dl>
<dd>Some examples are: minecraft, 404, 1a2b3c.</dd>
</dl>
</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>level-type</b></span></th>
<td>string</td>
<td>DEFAULT</td>
<td><span id="level-type"></span>Determines the type of map that is generated.
<dl>
<dd><b>DEFAULT</b> - Standard world with hills, valleys, water, etc.</dd>
<dd><b>FLAT</b> - A flat world with no features, meant for building.</dd>
<dd><b>LARGEBIOMES</b> - Same as default but all biomes are larger.</dd>
<dd><b>AMPLIFIED</b> - Same as default but world-generation height limit is increased.</dd>
<dd><b>CUSTOMIZED</b> - Same as default unless <b>generator-settings</b> is set to a preset.</dd>
</dl>
</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>max-build-height</b></span></th>
<td>integer</td>
<td>256</td>
<td><span id="max-build-height"></span>The maximum height in which building is allowed. Terrain may still naturally generate above a low height limit.</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>max-players</b></span></th>
<td>integer (0-2147483647)</td>
<td>20</td>
<td><span id="max-players"></span>The maximum number of players that can play on the server at the same time. Note that if more players are on the server it will use more resources. Note also, op player connections are not supposed to count against the max players, but ops currently cannot join a full server. Extremely large values for this field result in the client-side user list being broken.</td>
</tr>
<tr>
<th><span style="white-space: nowrap;"><b>max-tick-time</b></span><br></th>
<td>integer (0–(2^63 - 1))</td>
<td>60000</td>
<td><span id="max-tick-time"></span>The maximum number of milliseconds a single tick may take before the server watchdog stops the server with the message, <i>A single server tick took 60.00 seconds (should be max 0.05); Considering it to be crashed, server will forcibly shutdown.</i> Once this criteria is met, it calls System.exit(1).
<dl>
<dd><b>-1</b> - disable watchdog entirely (this disable option was added in 14w32a)</dd>
</dl>
</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>max-world-size</b></span><br></th>
<td>integer (1-29999984)</td>
<td>29999984</td>
<td><span id="max-world-size"></span>This sets the maximum possible size in blocks, expressed as a radius, that the <a href="/World_border" title="World border">world border</a> can obtain. Setting the world border bigger causes the commands to complete successfully but the actual border will not move past this block limit. Setting the max-world-size higher than the default doesn\'t appear to do anything.
<p>Examples:</p>
<ul>
<li>Setting max-world-size to 1000 will allow you to have a 2000x2000 world border.</li>
<li>Setting max-world-size to 4000 will give you an 8000 x 8000 world border.</li>
</ul>
</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>motd</b></span></th>
<td>string</td>
<td><i>A Minecraft Server</i></td>
<td><span id="motd"></span>This is the message that is displayed in the server list of the client, below the name.
<ul>
<li>The MOTD does support <a href="/Formatting_codes" title="Formatting codes">color and formatting codes</a>.</li>
<li>The MOTD supports special characters, such as "♥". However, such characters must be converted to escaped Unicode form. An online converter can be found <a target="_self" rel="nofollow" class="external text" href="http://www.freeformatter.com/string-utilities.html#charinfo">here</a></li>
<li>If the MOTD is over 59 characters, the server list will likely report a communication error.</li>
</ul>
</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>network-compression-threshold</b></span><br></th>
<td>integer</td>
<td>256</td>
<td><span id="network-compression-threshold"></span>By default it allows packets that are <i>n-1</i> bytes big to go normally, but a packet that <i>n</i> bytes or more will be compressed down. So, lower number means more compression but compressing small amounts of bytes might actually end up with a larger result than what went in.
<dl>
<dd><b>-1</b> - disable compression entirely</dd>
<dd><b>0</b> - compress everything</dd>
</dl>
<p><b>Note:</b> <i>The Ethernet spec requires that packets less than 64 bytes become padded to 64 bytes. Thus, setting a value lower than 64 may not be beneficial. It is also not recommended to exceed the MTU, typically 1500 bytes.</i></p>
</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>online-mode</b></span></th>
<td>boolean</td>
<td>true</td>
<td><span id="online-mode"></span>Server checks connecting players against Minecraft\'s account database. Only set this to false if your server is <b>not</b> connected to the Internet. Hackers with fake accounts can connect if this is set to false! If minecraft.net is down or inaccessible, no players will be able to connect if this is set to true. Setting this variable to off purposely is called "cracking" a server, and servers that are presently with online mode off are called "cracked" servers, allowing players with unlicensed copies of <a href="/Minecraft" title="Minecraft">Minecraft</a> to join.
<dl>
<dd><b>true</b> - Enabled. The server will assume it has an Internet connection and check every connecting player.</dd>
<dd><b>false</b> - Disabled. The server will not attempt to check connecting players.</dd>
</dl>
</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>op-permission-level</b></span></th>
<td>integer (1-4)</td>
<td>4</td>
<td><span id="op-permission-level"></span>Sets the default permission level for ops when using /op. All levels inherit abilities and commands from levels before them.
<dl>
<dd><b>1</b> - Ops can bypass spawn protection.</dd>
<dd><b>2</b> - Ops can use all singleplayer cheats commands (except /publish, as it is not on servers; along with /debug) and use command blocks. Command blocks and Realms operators/owners have this level.</dd>
<dd><b>3</b> - Ops can use most multiplayer-exclusive commands (all except level 4 commands).</dd>
<dd><b>4</b> - Ops can use all commands including /stop, /save-all, /save-on, and /save-off.</dd>
</dl>
</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>player-idle-timeout</b></span></th>
<td>integer</td>
<td>0</td>
<td><span id="player-idle-timeout"></span>If non-zero, players are kicked from the server if they are idle for more than that many minutes.
<dl>
<dd><b>Note:</b> <i>Idle time is reset when the server receives one of the following packets:</i>
<ul>
<li><a target="_self" rel="nofollow" class="external text" href="http://wiki.vg/Protocol#Click_Window">Click Window</a></li>
<li><a target="_self" rel="nofollow" class="external text" href="http://wiki.vg/Protocol#Enchant_Item">Enchant Item</a></li>
<li><a target="_self" rel="nofollow" class="external text" href="http://wiki.vg/Protocol#Update_Sign">Update Sign</a></li>
<li><a target="_self" rel="nofollow" class="external text" href="http://wiki.vg/Protocol#Player_Digging">Player Digging</a></li>
<li><a target="_self" rel="nofollow" class="external text" href="http://wiki.vg/Protocol#Player_Block_Placement">Player Block Placement</a></li>
<li><a target="_self" rel="nofollow" class="external text" href="http://wiki.vg/Protocol#Held_Item_Change_.28serverbound.29">Held Item Change</a></li>
<li><a target="_self" rel="nofollow" class="external text" href="http://wiki.vg/Protocol#Animation_.28serverbound.29">Animation</a> (swing arm)</li>
<li><a target="_self" rel="nofollow" class="external text" href="http://wiki.vg/Protocol#Entity_Action">Entity Action</a></li>
<li><a target="_self" rel="nofollow" class="external text" href="http://wiki.vg/Protocol#Client_Status">Client Status</a></li>
<li><a target="_self" rel="nofollow" class="external text" href="http://wiki.vg/Protocol#Chat_Message_.28serverbound.29">Chat Message</a></li>
<li><a target="_self" rel="nofollow" class="external text" href="http://wiki.vg/Protocol#Use_Entity">Use Entity</a></li>
</ul>
</dd>
</dl>
</td>
</tr>
<tr>
<th>prevent-proxy-connections</th>
<td>boolean</td>
<td>false</td>
<th>If the ISP/AS sent from the server is different from the one from Mojang\'s authentication server, the player is kicked
<p>true - <b>Enabled. Server prevents users from using vpns or proxies.</b></p>
<p>false - Disabled. The server doesn\'t prevent users from using vpns or proxies.</p>
</th>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>pvp</b></span></th>
<td>boolean</td>
<td>true</td>
<td><span id="pvp"></span>Enable PvP on the server. Players shooting themselves with arrows will only receive damage if PvP is enabled.
<dl>
<dd><b>true</b> - Players will be able to kill each other.</dd>
<dd><b>false</b> - Players cannot kill other players (also known as <b>Player versus Environment</b> (<b>PvE</b>)).</dd>
</dl>
<p><b>Note:</b> <i>Indirect damage sources spawned by players (such as <a href="/Lava" title="Lava">lava</a>, <a href="/Fire" title="Fire">fire</a>, <a href="/TNT" title="TNT">TNT</a> and to some extent <a href="/Water" title="Water">water</a>, <a href="/Sand" title="Sand">sand</a> and <a href="/Gravel" title="Gravel">gravel</a>) will still deal damage to other players.</i></p>
</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>query.port</b></span></th>
<td>integer (1-65534)</td>
<td>25565</td>
<td><span id="query.port"></span>Sets the port for the query server (see <b>enable-query</b>).</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>rcon.password</b></span></th>
<td>string</td>
<td><i>blank</i></td>
<td><span id="rcon.password"></span>Sets the password to rcon.</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>rcon.port</b></span></th>
<td>integer (1-65534)</td>
<td>25575</td>
<td><span id="rcon.port"></span>Sets the port to rcon.</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>resource-pack</b></span></th>
<td>string</td>
<td><i>blank</i></td>
<td><span id="resource-pack"></span>Optional URI to a <a href="/Resource_pack" title="Resource pack">resource pack</a>. The player may choose to use it.</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>resource-pack-sha1</b></span><br></th>
<td>string</td>
<td><i>blank</i></td>
<td><span id="resource-pack-hash"></span>Optional SHA-1 digest of the resource pack, in lowercase hexadecimal. It\'s recommended to specify this. This is not yet used to verify the integrity of the resource pack, but improves the effectiveness and reliability of caching.</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>server-ip</b></span></th>
<td>string</td>
<td><i>blank</i></td>
<td><span id="server-ip"></span>Set this if you want the server to bind to a particular IP. It is strongly recommended that you leave server-ip blank!
<dl>
<dd>Set to blank, or the IP you want your server to run (listen) on.</dd>
</dl>
</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>server-port</b></span></th>
<td>integer (1-65534)</td>
<td>25565</td>
<td><span id="server-port"></span>Changes the port the server is hosting (listening) on. This port must be <a href="https://en.wikipedia.org/wiki/Port_forwarding" class="extiw" title="wikipedia:Port forwarding">forwarded</a> if the server is hosted in a network using <a href="https://en.wikipedia.org/wiki/Network_address_translation" class="extiw" title="wikipedia:Network address translation">NAT</a> (If you have a home router/firewall).</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>snooper-enabled</b></span></th>
<td>boolean</td>
<td>true</td>
<td><span id="snooper-enabled"></span>Sets whether the server sends snoop data regularly to <a target="_self" rel="nofollow" class="external free" href="http://snoop.minecraft.net">http://snoop.minecraft.net</a>.
<dl>
<dd><b>false</b> - disable snooping.</dd>
<dd><b>true</b> - enable snooping.</dd>
</dl>
</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>spawn-animals</b></span></th>
<td>boolean</td>
<td>true</td>
<td><span id="spawn-animals"></span>Determines if <a href="/Animal" title="Animal" class="mw-redirect">animals</a> will be able to spawn.
<dl>
<dd><b>true</b> - Animals spawn as normal.</dd>
<dd><b>false</b> - Animals will immediately vanish.</dd>
</dl>
<p><i>Tip: if you have major lag, turn this off/set to false.</i></p>
</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>spawn-monsters</b></span></th>
<td>boolean</td>
<td>true</td>
<td><span id="spawn-monsters"></span>Determines if monsters will be spawned.
<dl>
<dd><b>true</b> - Enabled. Monsters will appear at night and in the dark.</dd>
<dd><b>false</b> - Disabled. No monsters.</dd>
</dl>
<p>This setting has no effect if difficulty = 0 (peaceful). If difficulty is not = 0, a monster can still spawn from a <a href="/Monster_Spawner" title="Monster Spawner">Monster Spawner</a>.</p>
<p><i>Tip: if you have major lag, turn this off/set to false.</i></p>
</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>spawn-npcs</b></span></th>
<td>boolean</td>
<td>true</td>
<td><span id="spawn-npcs"></span>Determines whether villagers will be spawned.
<dl>
<dd><b>true</b> - Enabled. Villagers will spawn.</dd>
<dd><b>false</b> - Disabled. No villagers.</dd>
</dl>
</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>spawn-protection</b></span></th>
<td>integer</td>
<td>16</td>
<td><span id="spawn-protection"></span>Determines the radius of the spawn protection as (x*2)+1. Setting this to 0 will not disable spawn protection. 0 will protect the single block at the spawn point. 1 will protect a 3x3 area centered on the spawn point. 2 will protect 5x5, 3 will protect 7x7, etc. This option is not generated on the first server start and appears when the first player joins. If there are no <a href="/Operator" title="Operator" class="mw-redirect">ops</a> set on the server, the spawn protection will be disabled automatically.</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>use-native-transport</b></span></th>
<td>boolean</td>
<td>true</td>
<td><span id="use-native-transport"></span>Linux server performance improvements: optimized packet sending/receiving on Linux
<dl>
<dd><b>true</b> - Enabled. Enable Linux packet sending/receiving optimization</dd>
<dd><b>false</b> - Disabled. Disable Linux packet sending/receiving optimization</dd>
</dl>
</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>view-distance</b></span></th>
<td>integer (2-32)</td>
<td>10</td>
<td><span id="view-distance"></span>Sets the amount of world data the server sends the client, measured in chunks in each direction of the player (radius, not diameter). It determines the server-side viewing distance. (see <a href="/Frame_rate#Render_distance" title="Frame rate" class="mw-redirect">Render distance</a>)
<p><i>10 is the default/recommended. If you have major lag, reduce this value.</i></p>
</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>white-list</b></span></th>
<td>boolean</td>
<td>false</td>
<td><span id="white-list"></span>Enables a whitelist on the server.
<p>With a whitelist enabled, users not on the whitelist will be unable to connect. Intended for private servers, such as those for real-life friends or strangers carefully selected via an application process, for example.</p>
<dl>
<dd><b>false</b> - No white list is used.</dd>
<dd><b>true</b> - The file whitelist.json is used to generate the white list.</dd>
</dl>
<p><b>Note:</b> <i>Ops are automatically white listed, and there is no need to add them to the whitelist.</i></p>
</td>
</tr>
</tbody></table> 

=================

<tr>
<th><span style="white-space:nowrap;"><b>allow-flight</b></span></th>
<td>boolean</td>
<td>false</td>
<td>Erlaubt es Spielern, auch im <a href="/%C3%9Cberlebensmodus" title="Überlebensmodus">Überlebensmodus</a> zu fliegen, sofern diese eine <a href="/Mod" title="Mod" class="mw-redirect">Mod</a> zum Fliegen installiert haben. Wenn diese Option aktiviert ist, kann es mehr <a href="/Griefing" title="Griefing">Griefing</a> geben, weil dies durch Fliegen vereinfacht wird. Im <a href="/Kreativmodus" title="Kreativmodus">Kreativmodus</a> hat die Option keine Auswirkung.
<dl>
<dd><b>false</b> - Fliegen ist nicht erlaubt (Spieler, die mehr als 5 Sekunden in der Luft sind, werden vom Server gekickt).</dd>
<dd><b>true</b> - Das Fliegen ist erlaubt und kann genutzt werden, wenn entsprechende Mods installiert sind.</dd>
</dl>
</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>allow-nether</b></span></th>
<td>boolean</td>
<td>true</td>
<td>Erlaubt es Spielern, in den <a href="/Nether" title="Nether" class="mw-redirect">Nether</a> zu reisen.
<dl>
<dd><b>false</b> - <a href="/Netherportal" title="Netherportal">Netherportale</a> sind deaktiviert.</dd>
<dd><b>true</b> - Es ist möglich, durch Portale in den Nether zu reisen.</dd>
</dl>
</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>announce-player-achievements</b></span></th>
<td>boolean</td>
<td>true</td>
<td>Erzielt ein Spieler einen <a href="/Erfolg" title="Erfolg" class="mw-redirect">Erfolg</a>, erhalten die anderen Spieler eine Nachricht.
<dl>
<dd><b>false</b> - Keine öffentlichen Erfolgsnachrichten.</dd>
<dd><b>true</b> - Erfolgsnachrichten werden über den Chat veröffentlicht.</dd>
</dl>
</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>difficulty</b></span></th>
<td>integer (0-3)</td>
<td>1</td>
<td>Definiert den <a href="/Schwierigkeitsgrad" title="Schwierigkeitsgrad">Schwierigkeitsgrad</a> auf dem Server.
<dl>
<dd><b>0</b> - Friedlich</dd>
<dd><b>1</b> - Einfach</dd>
<dd><b>2</b> - Normal</dd>
<dd><b>3</b> - Schwer</dd>
</dl>
</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>enable-query</b></span></th>
<td>boolean</td>
<td>false</td>
<td>Wenn diese Option aktiviert ist, können Informationen über den Server von außen abgefragt werden. Das Datenformat ist <i>GameSpy4</i> und wird hier erläutert: <a target="_self" rel="nofollow" class="external free" href="http://wiki.vg/Query">http://wiki.vg/Query</a>. Wenn man ein entsprechendes PHP-Skript programmiert, kann man z.B. auf einer Webseite anzeigen, welche Spieler auf dem Server aktiv sind.</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>enable-rcon</b></span></th>
<td>boolean</td>
<td>false</td>
<td>Aktiviert den Fernzugriff für die Server-Konsole (rcon = <i>remote control</i>). Das Protokoll wird hier erläutert: <a target="_self" rel="nofollow" class="external free" href="http://wiki.vg/Rcon">http://wiki.vg/Rcon</a>.</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>enable-command-block</b></span></th>
<td>boolean</td>
<td>false</td>
<td>Aktiviert/deaktiviert den Befehlsblock.
<dl>
<dd><b>true</b> - Aktiviert den Befehlsblock.</dd>
<dd><b>false</b> - Deaktiviert den Befehlsblock.</dd>
</dl>
</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>force-gamemode</b></span></th>
<td>boolean</td>
<td>false</td>
<td>Legt fest, in welchem <a href="/Spielmodus" title="Spielmodus">Spielmodus</a> die Spieler dem Server beitreten.
<dl>
<dd><b>false</b> - Spieler werden bei Serverbeitritt in dem Spielmodus sein, in dem sie den Server verlassen haben.</dd>
<dd><b>true</b> - Spieler werden bei Serverbeitritt immer im Standardspielmodus sein, der mit der Option <b>gamemode</b> festgelegt ist.</dd>
</dl>
</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>gamemode</b></span></th>
<td>integer (0-3)</td>
<td>0</td>
<td>Definiert den <a href="/Spielmodus" title="Spielmodus">Spielmodus</a>, den Spieler beim ersten Besuch des Servers erhalten.
<dl>
<dd><b>0</b> - Überlebensmodus</dd>
<dd><b>1</b> - Kreativmodus</dd>
<dd><b>2</b> - Abenteuermodus</dd>
<dd><b>3</b> - Zuschauermodus</dd>
</dl>
</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>generate-structures</b></span></th>
<td>boolean</td>
<td>true</td>
<td>Definiert, ob Gebäude (wie <a href="/Dorf" title="Dorf">Dörfer</a>) generiert werden.
<dl>
<dd><b>false</b> - In neuen <a href="/Chunk" title="Chunk">Chunks</a> werden Gebäude nicht generiert.</dd>
<dd><b>true</b> - In neuen Chunks werden Gebäude generiert.</dd>
</dl>
</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>generator-settings</b></span></th>
<td>string</td>
<td>leer</td>
<td>Definiert die Einstellungen zur Generierung von <a href="/Flachland" title="Flachland">Flachland</a>- und <a href="/Angepasst" title="Angepasst">Angepasst</a>-Welten. Beispiele siehe jeweils dort.</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>hardcore</b></span></th>
<td>boolean</td>
<td>false</td>
<td>Standardmäßig fehlt diese Option in den server.properties, was gleichbedeutend mit <i>false</i> ist. Die Einstellung <i>true</i> kann nur ein einziges Mal verwendet werden, nämlich <i>vor</i> dem ersten Start des Servers. Dann wird der <a href="/Hardcore-Modus" title="Hardcore-Modus">Hardcore-Modus</a> aktiviert, d. h. Spieler werden permanent vom Server gebannt, sobald sie sterben. Die Aktivierung oder Nicht-Aktivierung des Hardcore-Modus wird bei der Generierung der Welt in die <a href="/Weltdaten" title="Weltdaten">Weltdaten</a> eingetragen. Danach ist eine Änderung dieser Einstellung nicht mehr möglich.</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>level-name</b></span></th>
<td>string</td>
<td>world</td>
<td>Der Name der Welt und des Ordners, wo sie gespeichert wird. Es ist auch möglich, hier einen Pfad anzugeben, z. B. worlds/worldname/worlddataname, hierbei sind "worlds" und "worldname" Unterordner. "worldname" steht für den Dateinamen unter dem die Welt gespeichert werden soll. So ist es möglich, mehrere Welten zu speichern (oder den Server-Ordner besser zu sortieren). Sonderzeichen wie \' (Apostroph) müssen eventuell durch einen Backslash (\) vor ihnen markiert werden.</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>level-seed</b></span></th>
<td>string</td>
<td><i>leer</i></td>
<td>Legt den <a href="/Startwert" title="Startwert">Startwert</a> für die Welt fest.</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>level-type</b></span></th>
<td>string</td>
<td>DEFAULT</td>
<td>Bestimmt den <a href="/Welttyp" title="Welttyp">Welttyp</a>. ACHTUNG! Nach einer Änderung dieser Option sollte eine neue Serverwelt gestartet werden. Falls die Welt beibehalten wird, kommt es zu unerwünschten Schnitten in der Landschaft, an allen Stellen, an denen neue Chunks generiert werden.
<dl>
<dd><b>DEFAULT</b> - Normalwelt mit Hügeln, Tälern, Dörfern, etc.</dd>
<dd><b>FLAT</b> - Eine komplett flache Welt. Der Aufbau der Ebenen kann über die Option <i>generator-settings</i> individuell festgelegt werden.</dd>
<dd><b>LARGEBIOMES</b> - Ähnlich wie die Standardwelt, nur mit extrem großen Biomen.</dd>
<dd><b>AMPLIFIED</b> - Ähnlich wie die Standardwelt, nur mit extremen Höhenunterschieden und zerklüfteten Bergen bis in <a href="/H%C3%B6he" title="Höhe">Höhe</a> 256. Die Verteilung der Biome bleibt dabei gleich.</dd>
<dd><b>CUSTOMIZED</b> - Eine individuell gestaltete Welt, deren Aufbau über die Option <i>generator-settings</i> festgelegt wird.</dd>
</dl>
</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>max-build-height</b></span></th>
<td>integer</td>
<td>256</td>
<td>Die maximale Höhe, in der gebaut werden kann. Der <a href="/Weltgenerator" title="Weltgenerator" class="mw-redirect">Weltgenerator</a> beachtet diese Höhe nicht.</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>max-players</b></span></th>
<td>integer<br>
(1-2147483647)</td>
<td>20</td>
<td>Die maximale Anzahl an Spielern, die gleichzeitig auf diesem Server spielen können. Je mehr Spieler auf einem Server sind, desto mehr Leistung benötigt dieser Server. Operatoren zählen auch als Spieler. Wenn die maximale Anzahl an Spielern erreicht ist, kann auch ein Operator dem Server nicht beitreten. Bei sehr hohen Werten kann die Spielerliste, die per <kbd class="keyboard-key nowrap" style="border: 1px solid #aaa; -moz-border-radius: 2px; -webkit-border-radius: 2px; border-radius: 2px; -moz-box-shadow: 1px 2px 2px #ddd; -webkit-box-shadow: 1px 2px 2px #ddd; box-shadow: 1px 2px 2px #ddd; background-color: #f9f9f9; background-image: -moz-linear-gradient(top, #eee, #f9f9f9, #eee); background-image: -ms-linear-gradient(top, #eee, #f9f9f9, #eee); background-image: -o-linear-gradient(top, #eee, #f9f9f9, #eee); background-image: -webkit-linear-gradient(top, #eee, #f9f9f9, #eee); background-image: linear-gradient(top, #eee, #f9f9f9, #eee); padding: 1px 3px; font-family: inherit; font-size: 0.85em;">Tab ↹</kbd> geöffnet werden kann, nicht mehr alle Spieler anzeigen.</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>max-tick-time</b></span></th>
<td>integer<br>
(0–(2^63 - 1))</td>
<td>60000</td>
<td>Das Spiel ist <a href="/Tick" title="Tick">Tick</a>-basiert, d.h. mit jedem Tick werden Aktionen in der Welt ausgeführt, auch wenn der Spieler sich nicht bewegt. Ein Tick findet normalerweise alle 50 Millisekunden statt. Ist der Server zu stark belastet, finden die Ticks seltener statt, z.B. bei riesigen Tierpopulationen oder gigantischen Drop-Anzahlen durch umfangreiche TNT-Explosionen. Dann bewegen sich die Monster und anderen Objekte so langsam, dass man nicht mehr vernünftig spielen kann. Mit diesem Parameter kann man einstellen, dass sich der Server von selbst stoppt, sobald ein Tick einen bestimmten Wert (Standard = 60 Sekunden) überschreitet. Die Meldung lautet dann: "A single server tick took 60.00 seconds (should be max 0.05); Considering it to be crashed, server will forcibly shutdown."
<dl>
<dd><b>-1</b> deaktiviert die Selbstüberwachung.</dd>
</dl>
</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>max-world-size</b></span></th>
<td>integer<br>
(1-29999984)</td>
<td>29999984</td>
<td>Maximalradius der <a href="/Weltbarriere" title="Weltbarriere">Weltbarriere</a>. Standardmäßig liegt er einen <a href="/Chunk" title="Chunk">Chunk</a> (16 Blöcke) unter der maximalen Weltgröße von ± 30.000.000 Blöcken, ein größerer Wert wird nicht beachtet. Der Maximalradius legt fest, wie weit die Weltbarriere mit dem <a href="/Befehl" title="Befehl">Befehl</a> <code><a href="/Befehl/worldborder" title="Befehl/worldborder">/worldborder</a></code> im Spiel verändert werden kann. Achtung: der Befehl ändert den Durchmesser, hier wird der maximale Radius angegeben.</td>
</tr>
<tr>
<th><span id="motd"></span><span style="white-space:nowrap;"><b>motd</b></span></th>
<td>string</td>
<td><i>A Minecraft Server</i></td>
<td>Ein Text, der in der Serverliste unter dem Namen des Servers angezeigt wird (motd = <i>Message of the Day</i>).
<ul>
<li>Die Motd unterstützt <a href="/Formatierungscodes" title="Formatierungscodes">Formatierungscodes</a>, die den Farben und Formatierungsmöglichkeiten entsprechen, die man bei <a href="/JSON-Text" title="JSON-Text">JSON-Texten</a> verwenden kann.</li>
<li>Eine lange Motd wird über maximal zwei Zeilen angezeigt. Alle weiteren Zeichen werden abgeschnitten.</li>
<li>Ein Zeilenumbruch kann mit dem Code <code>\u000A</code> herbeigeführt werden.</li>
</ul>
</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>network-compression-threshold</b></span></th>
<td>integer</td>
<td>256</td>
<td>Zwischen <a href="/Client-Server-Konzept" title="Client-Server-Konzept">Client und Server</a> werden ständig Datenpakete ausgetauscht: Der Server informiert den Client, wie die Welt aussieht und wo sich alle Spieler und Kreaturen befinden, und der Client stellt dies als Bild dar. Umgekehrt informiert der Client den Server über aller Aktionen des Spielers, damit der Server die Welt entsprechend aktualisieren kann. Diese Datenpakete können unkomprimiert oder komprimiert durch die Netzverbindung laufen. Die Einstellung <i>network-compression-threshold</i> gibt die Größe in Bytes an, ab der die versendeten Datenpakete komprimiert werden. Eine niedrige Zahl bedeutet häufigeres Komprimieren und somit kleinere Pakete. Wird die Einstellung jedoch zu niedrig gewählt, kann es vorkommen, dass die komprimierten Pakete sogar größer als die ursprünglichen sind (Beispiel: komprimiert man eine 64 Byte große Textdatei beispielweise mit <i>zip</i>, ist das Ergebnis 131 Bytes groß.)
<ul>
<li>-1 bedeutet überhaupt keine Komprimierung</li>
<li>0 bedeutet Komprimierung unabhängig von der Paketgröße</li>
<li>größere Zahlen geben die Größe an, ab der die Pakete komprimiert werden</li>
</ul>
<p>Die <a href="http://de.wikipedia.org/wiki/Ethernet" class="extiw" title="de.wikipedia:Ethernet">Ethernet</a>-Spezifikation erfordert, dass Pakete kleiner als 64 Bytes auf 64 Bytes aufgefüllt werden. Aus diesem Grund macht es keinen Sinn, einen Wert kleiner als 64 einzugeben. Ebenfalls ist es nicht zu empfehlen, die <a href="http://de.wikipedia.org/wiki/Maximum_Transmission_Unit" class="extiw" title="de.wikipedia:Maximum Transmission Unit">Maximum Transmission Unit</a> (maximal transportierbare Paketgröße, MTU) von normalerweise 1500 Bytes zu überschreiten.</p>
</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>online-mode</b></span></th>
<td>boolean</td>
<td>true</td>
<td>Wenn diese Option aktiviert ist, vergleicht der Server jeden Spieler, der sich verbinden will, mit der Datenbank von <a href="/Mojang" title="Mojang" class="mw-redirect">Mojang</a>. Diese Option sollte nur auf <i>false</i> gesetzt werden, wenn der Server nicht mit dem Internet verbunden ist und wenn keine White-List existiert (siehe Option <i>white-list</i>). Die Option <i>online-mode</i> dient der Sicherheit, denn es wird geprüft, ob der Spieler einen gültigen Account hat. Fake-Accounts werden damit aufgedeckt. Server deren <i>online-mode</i> auf <i>false</i> steht, werden "<a href="/Crack" title="Crack">cracked</a>" Server genannt.
<p>Wenn die Dienste von Mojang allerdings offline oder anderweitig nicht erreichbar sind (siehe <a target="_self" rel="nofollow" class="external text" href="https://help.mojang.com/">Status der Mojang-Server</a>), kann kein Spieler mehr dem Spiel-Server beitreten, falls die Option auf <i>true</i> steht.</p>
<dl>
<dd><b>true</b> - Aktiviert. Der Server nimmt an, dass eine Internetverbindung besteht und vergleicht jeden verbundenen Spieler mit der Datenbank von Mojang.</dd>
<dd><b>false</b> - Deaktiviert. Der Server vergleicht verbindene Spieler nicht mit der Datenbank.</dd>
</dl>
</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>op-permission-level</b></span></th>
<td>integer (1-4)</td>
<td>4</td>
<td>Bestimmt das Standard-Berechtigungslevel für Spieler, die mit dem <a href="/Befehl" title="Befehl">Befehl</a> <code><a href="/Befehl/op" title="Befehl/op">/op</a></code> zum <a href="/Operator" title="Operator">Operator</a> gemacht wurden. Danach ist eine individuelle Anpassung des Levels für einzelne Spieler über die Datei "ops.json" möglich (siehe unten).
<dl>
<dd><b>1</b> - Operatoren mit Level 1 können Veränderungen im ansonsten geschützen <a href="/Spawn" title="Spawn">Spawnbereich</a> vornehmen.</dd>
<dd><b>2</b> - Operatoren mit Level 2 können Befehlsblöcke editieren und alle Cheat-<a href="/Befehl" title="Befehl">Befehle</a> ausführen außer denen von Level 3 und 4.</dd>
<dd><b>3</b> - Operatoren mit Level 3 können die Server-<a href="/Befehl" title="Befehl">Befehle</a> zur Spielersanktion (<a href="/Befehl" title="Befehl">Befehl</a> <code><a href="/Befehl/kick" title="Befehl/kick">/kick</a></code>, <a href="/Befehl" title="Befehl">Befehl</a> <code><a href="/Befehl/ban" title="Befehl/ban">/ban</a></code> etc.) und zur Ernennung weiter Operatoren (<a href="/Befehl" title="Befehl">Befehl</a> <code><a href="/Befehl/op" title="Befehl/op">/op</a></code>) ausführen.</dd>
<dd><b>4</b> - Operatoren mit Level 4 können mit dem <a href="/Befehl" title="Befehl">Befehl</a> <code><a href="/Befehl/stop" title="Befehl/stop">/stop</a></code> den Server stoppen.</dd>
</dl>
</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>player-idle-timeout</b></span></th>
<td>integer</td>
<td>0</td>
<td>Wenn der Wert nicht 0 ist, werden inaktive Spieler nach der angegeben Zeit in Minuten vom Server gekickt. Die Zeit wird für einen Spieler zurückgesetzt, wenn er eine Aktion im Spiel auslöst, sich bewegt, einen Menüpunkt aufruft oder im Chat schreibt. Im Einzelnen sind es folgende Signale, die die Inaktiv-Zeit zurücksetzen:
<dl>
<dd>
<ul>
<li>3 (0x3) Chat</li>
<li>7 (0x7) UseEntity</li>
<li>14 (0xe) BlockDig</li>
<li>15 (0xf) Place</li>
<li>16 (0x10) BlockItemSwitch</li>
<li>18 (0x12) ArmAnimation</li>
<li>19 (0x13) EntityAction</li>
<li>102 (0x66) WindowClick</li>
<li>108 (0x6c) ButtonClick</li>
<li>130 (0x82) UpdateSign</li>
<li>205 (0xcd) ClientCommand</li>
</ul>
</dd>
</dl>
</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>pvp</b></span></th>
<td>boolean</td>
<td>true</td>
<td>Aktiviert PvP (<b>Player versus Player</b>) auf dem Server. Im PvP-Modus können sich Spieler gegenseitig direkten Schaden zufügen. Ohne PvP können sie sich nur indirekt schädigen, z.B. durch <a href="/Lava" title="Lava">Lava</a>, <a href="/Feuer" title="Feuer">Feuer</a>, <a href="/TNT" title="TNT">TNT</a> und im weiteren Sinne mit <a href="/Wasser" title="Wasser">Wasser</a>, <a href="/Sand" title="Sand">Sand</a> und <a href="/Kies" title="Kies">Kies</a>.
<dl>
<dd><b>true</b> - Spieler können andere Spieler töten.</dd>
<dd><b>false</b> - Spieler können andere Spieler nicht töten (auch genannt <i>Player versus Environment</i> (PvE)).</dd>
</dl>
</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>query.port</b></span></th>
<td>integer (1-65534)</td>
<td>25565</td>
<td>Definiert den Port für den Query-Server (siehe <b>enable-query</b>).</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>rcon.password</b></span></th>
<td>string</td>
<td><i>leer</i></td>
<td>Defniert das Passwort für den Fernzugriff auf den Server (siehe <b>enable-rcon</b>).</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>rcon.port</b></span></th>
<td>integer (1-65534)</td>
<td>25575</td>
<td>Definiert den Port für den Fernzugriff auf den Server (siehe <b>enable-rcon</b>).</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>resource-pack</b></span></th>
<td>string</td>
<td>leer</td>
<td>Ein Server kann ein <a href="/Ressourcenpaket" title="Ressourcenpaket">Ressourcenpaket</a> empfehlen, um z.B. zusätzliche Sounds zur Verfügung zu stellen (sind über <a href="/Befehlsblock" title="Befehlsblock">Befehlsblöcke</a> abspielbar) oder eine spezielle Übersetzung einzelner Texte (z.B. der <a href="/Tod" title="Tod">Todesmeldungen</a>) oder auch besondere <a href="/Textur" title="Textur" class="mw-redirect">Texturen</a>. Dazu ist hier die Webadresse (URL) des Downloads einzutragen. Dabei gibt es einige Einschränkungen:
<ul>
<li>Die URL muss auf eine zip-Datei verweisen. Eine andere Kompression oder ein unkomprimiertes Ressourcenpaket sind nicht möglich.</li>
<li>Das Ressourcenpaket darf maximal 50 MB groß sein.</li>
<li>Die Datei muss die <a href="/Ressourcenpaket#Aufbau" title="Ressourcenpaket">Bedingungen für ein Ressourcenpaket</a> erfüllen (z.B. muss sie die Datei <i>pack.mcmeta</i> enthalten).</li>
</ul>
<p>Sobald sich ein Client erstmalig mit dem Server verbindet (siehe <a href="/Client-Server-Konzept" title="Client-Server-Konzept">Client-Server-Konzept</a>), wird - je nach <a href="/Men%C3%BC/Mehrspieler/Bearbeiten" title="Menü/Mehrspieler/Bearbeiten">gewählter Einstellung</a> - die Datei mit oder ohne Rückfrage oder gar nicht im Hintergrund herunterladen und installiert.</p>
</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>resource-pack-hash</b></span></th>
<td>string</td>
<td>leer</td>
<td>Optionale Prüfsumme ("<a href="http://de.wikipedia.org/wiki/Secure_Hash_Algorithm" class="extiw" title="de.wikipedia:Secure Hash Algorithm">SHA1-Digest</a>") des <a href="/Ressourcenpaket" title="Ressourcenpaket">Ressourcenpaketes</a> in kleingeschriebenen Hexadezimalzeichen. Es wird empfohlen, die Prüfsumme anzugeben. Sie wird zwar bislang nicht für ihren eigentlichen Zweck verwendet, zu prüfen, ob das Ressourcenpaket nachträglich verändert wurde, aber sie verbessert die Wirksamkeit und Zuverlässigkeit der Datenzwischenspeicherung.</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>server-ip</b></span></th>
<td>string</td>
<td><i>leer</i></td>
<td>Wenn der Server unter einer bestimmten IP-Adresse laufen soll, muss diese hier eingetragen werden. Es ist zu empfehlen, diesen Wert leer zu lassen.</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>server-port</b></span></th>
<td>integer (1-65534)</td>
<td>25565</td>
<td>Der Port, auf dem der Server läuft. Wenn das Netzwerk, in dem der Server läuft, <a href="http://de.wikipedia.org/wiki/Network_Address_Translation" class="extiw" title="de.wikipedia:Network Address Translation">NAT</a> benutzt (z.B. durch einen Router), muss der Port dort <a href="http://de.wikipedia.org/wiki/Portweiterleitung" class="extiw" title="de.wikipedia:Portweiterleitung">weitergeleitet</a> werden.</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>snooper-enabled</b></span></th>
<td>boolean</td>
<td>true</td>
<td>Legt fest, ob der Server anonyme Daten über den Server an <a target="_self" rel="nofollow" class="external free" href="http://snoop.minecraft.net">http://snoop.minecraft.net</a> senden darf.
<dl>
<dd><b>false</b> - Deaktiviert das Senden von Daten.</dd>
<dd><b>true</b> - Aktiviert das Senden von Daten.</dd>
</dl>
</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>spawn-animals</b></span></th>
<td>boolean</td>
<td>true</td>
<td>Bestimmt, ob Tiere spawnen können. Bei Leistungsproblem des Servers sollte diese Option deaktiviert werden.
<dl>
<dd><b>true</b> - Tiere können spawnen.</dd>
<dd><b>false</b> - Tiere verschwinden, nachdem sie gespawnt sind, sofort wieder.<br></dd>
</dl>
</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>spawn-monsters</b></span></th>
<td>boolean</td>
<td>true</td>
<td>Bestimmt, ob Monster außerhalb von Monsterspawnern spawnen können. Bei Leistungsproblem des Servers sollte diese Option deaktiviert werden.
<dl>
<dd><b>true</b> - Monster spawnen außerhalb von Monsterspawnern. <a href="/Ozelot" title="Ozelot">Ozelots</a> spawnen im Dschungel.</dd>
<dd><b>false</b> - Monster spawnen nur an Monsterspawnern und Ozelots spawnen gar nicht.</dd>
</dl>
<p>Diese Option ist nutzlos, wenn difficulty = 0 (friedlich) ist.</p>
</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>spawn-npcs</b></span></th>
<td>boolean</td>
<td>true</td>
<td>Bestimmt, ob <a href="/Dorfbewohner" title="Dorfbewohner">Dorfbewohner</a> spawnen können.
<dl>
<dd><b>true</b> - Dorfbewohner können spawnen.</dd>
<dd><b>false</b> - Dorfbewohner können nicht spawnen.</dd>
</dl>
</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>spawn-protection</b></span></th>
<td>integer</td>
<td>16</td>
<td>Legt den Radius eines geschützen Bereiches um den <a href="/Spawnpunkt" title="Spawnpunkt" class="mw-redirect">Spawnpunkt</a> fest. Der Bereich ist in sämtlichen <a href="/H%C3%B6he" title="Höhe">Ebenen</a> von 0 bis 255 geschützt. Der Wert 0 schützt nur den Block des Spawnpunktes (siehe <i>SpawnX</i> und <i>SpawnZ</i> in den <a href="/Weltdaten" title="Weltdaten">Weltdaten</a>). Der Wert 1 entspricht einem Radius von einem Block um den zentralen Block, also einem 3×3 Blöcke großen Bereich, etc. Der Standardradius sind 16 Blöcke, was einen geschützten Bereich von 33×33 Blöcken ergibt.
<p>Spieler ohne <a href="/Operator" title="Operator">Operator</a>-Rechte (siehe <a href="/Befehl" title="Befehl">Befehl</a> <code><a href="/Befehl/op" title="Befehl/op">/op</a></code>) können dort weder Blöcke abbauen noch setzen noch irgendwelche <a href="/Redstone-Element" title="Redstone-Element">Redstone-Signalgeber oder -Empfänger</a> betätigen (also keine Knöpfe, Hebel, Türen, Zauntore etc.). Einzige Ausnahme: <a href="/Druckplatte" title="Druckplatte">Druckplatten</a>.</p>
<p>Allerdings können explodierende <a href="/Creeper" title="Creeper">Creeper</a> (wenn es nicht über den <a href="/Befehl" title="Befehl">Befehl</a> <code><a href="/Befehl/gamerule" title="Befehl/gamerule">/gamerule</a></code> abgeschaltet wurde) auch im geschützen Bereich Schaden anrichten, genauso wie <a href="/TNT" title="TNT">TNT</a>, das an der Grenze zum geschützten Bereich gezündet wurde. Wasser und Lava können hineinfließen und Feuer kann (wenn es nicht über den <a href="/Befehl" title="Befehl">Befehl</a> <code><a href="/Befehl/gamerule" title="Befehl/gamerule">/gamerule</a></code> abgeschaltet wurde) auf den geschützten Bereich übergreifen. Auch Kolben können Blöcke in diesen Bereich hinein schieben.</p>
<p>Die Option <i>spawn-protection</i> ist nicht in den initialen server.properties enthalten. Sie erscheint erst, wenn der erste Spieler den Server betritt.</p>
</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>view-distance</b></span></th>
<td>integer (3-15)</td>
<td>10</td>
<td>Definiert die Menge an Welt-Daten, die der Server an den Client sendet, gemessen in <a href="/Chunk" title="Chunk">Chunks</a>. Bestimmt wird dadurch die serverseitig festgelegte Sichtweite. Bei der Standard-Einstellung von 10 Chunks werden insgesamt 441 Chunks gesendet (10 Chunks vor und hinter dem Spielerchunk = 21, dasselbe rechts und links = 21 x 21). Die Anzahl an Chunks, die der Server lädt, kann im <a href="/Debug-Bildschirm" title="Debug-Bildschirm">Debug-Bildschirm</a> eingesehen werden. Bei Leistungsproblem des Servers sollte der Wert verkleinert werden.</td>
</tr>
<tr>
<th><span style="white-space:nowrap;"><b>white-list</b></span></th>
<td>boolean</td>
<td>false</td>
<td>Aktiviert eine White-List auf dem Server. Wenn die White-List aktiviert ist, können nur Spieler dem Server beitreten, die auf dieser gelistet sind. Diese Option ist für Privat-Server, auf denen nur ausgewählte Freunde spielen sollen und für Server, die ihre Mitglieder durch ein Bewerbungsverfahren aussuchen, zu empfehlen. Wenn diese Option aktiviert ist, muss die Option <i>online-mode</i> aktiviert sein. Das ist auch sinnvoll, denn ansonsten könnte trotz White-List jeder beliebige Spieler dem Server beitreten, wenn er einfach einen dort gelisteten Namen verwendet, falls er einen solchen kennt. Die White-List wird über die <a href="/Server-Konsole" title="Server-Konsole">Server-Konsole</a> mit dem <a href="/Befehl" title="Befehl">Befehl</a> <code><a href="/Befehl/whitelist" title="Befehl/whitelist">/whitelist</a></code> verwaltet.
<dl>
<dd><b>false</b> - Es wird keine White-List benutzt.</dd> 
<dd><b>true</b> - Jeder Spieler, der sich mit dem Server verbinden will, muss in der White-List eingetragen sein.</dd>
</dl>
</td>
</tr>
</tbody></table>';

preg_match_all('/<tr>(.*?)<\/tr/si', $p, $matches);
foreach ($matches[1] as $line) {

    preg_match_all('/<t.>(.*?)<\/t/si', $line, $m2);

    $dataset = array(
        'cmd' => strip_tags($m2[1][0]),
        'type' => trim($m2[1][1]),
        'default' => trim($m2[1][2]),
        'value' => trim($m2[1][2]),
        'en' => '',
    );

    if (!isset($cmds[$dataset['cmd']])) {
        $dataset['en'] = preg_replace('/<span.*?<\/span>/si', '', $m2[1][3]);
        $cmds[$dataset['cmd']] = $dataset;
    } else {
        $cmds[$dataset['cmd']]['de'] = preg_replace('/<span.*?<\/span>/si', '', $m2[1][3]);
    }



}

echo json_encode($cmds, JSON_PRETTY_PRINT);