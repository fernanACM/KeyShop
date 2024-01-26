[![](https://poggit.pmmp.io/shield.state/KeyShop)](https://poggit.pmmp.io/p/KeyShop)

[![](https://poggit.pmmp.io/shield.api/KeyShop)](https://poggit.pmmp.io/p/KeyShop)
# KeyShop
A store plugin to sell keys on your server. Only for PocketMine-MP 5.0

![keyshop-icon](https://github.com/fernanACM/KeyShop/assets/83558341/028f36e8-f19c-487b-a202-edf36cbb61b1)
<a href="https://discord.gg/YyE9XFckqb"><img src="https://img.shields.io/discord/837701868649709568?label=discord&color=7289DA&logo=discord" alt="Discord" /></a>

### 📸 Images
<img src="https://github.com/fernanACM/KeyShop/assets/83558341/4e94ca04-2c10-4eab-b44a-8161b3b42bd9">

## 🌍 Wiki
* Check our plugin [wiki](https://github.com/fernanACM/KeyShop/wiki) for features and secrets in the...

### 💡 Implementations
* [X] Configuration
* [X] EconomyAPI and BedrockEconomy support 
* [X] Multisupport keys

### 💾 Config
```yaml
#  _  __                 ____    _                     
# | |/ /   ___   _   _  / ___|  | |__     ___    _ __  
# | ' /   / _ \ | | | | \___ \  | '_ \   / _ \  | '_ \ 
# | . \  |  __/ | |_| |  ___) | | | | | | (_) | | |_) |
# |_|\_\  \___|  \__, | |____/  |_| |_|  \___/  | .__/ 
#                |___/                          |_|    
#         by fernanACM
# A store plugin to sell keys on your server. It accepts 
# all types of keys from each plugin, which is why it is unique in its kind.

# DO NOT TOUCH!
config-version: "1.0.0"
# Prefix plugin
Prefix: "&l&f[&bKEYSHOP&f]&8»&r "
# Usa economyapi, bedrockeconomy, xp
Economy: 
  provider: bedrockeconomy
# Here put the command to give you a key
# {PLAYER} => Player name
# {KEY} => The key has to be received
# {AMOUNT} => The number of keys
Key-command: key give "{PLAYER}" {KEY} {AMOUNT}
# EXAMPLE:
# KEYS:
# - {LINE} => Line break
# - {AMOUNT} => Number of keys
# - {PRICE} => Price of the key
# - "&" => Color
# KeyShop:
#   Common: // THE NAME OF THE KEY WILL GO HERE (MUST BE EXACT)
#     name: "&l&cCOMUN{LINE}&r&0x{AMOUNT} | cost: {PRICE}$" // OPTIONAL
#     price: 323 // Key price
#     image: "textures/items/cancel" // OPTIONAL - URL or PATH
#     amount: 2 // Number of keys to receive
KeyShop:
  Common:
    price: 334
    name: "&l&cCOMMON{LINE}&r&0x{AMOUNT} | cost: {PRICE}$"
    image: "textures/items/diamond" # Ruta de la imagen (opcional)
    amount: 1
  Epic:
    price: 323
    name: "&l&5EPIC{LINE}&r&0x{AMOUNT} | cost: {PRICE}$"
    image: "https://preview.redd.it/you-have-an-ugly-gray-creeper-instead-of-a-minecraft-icon-v0-y83ppc5i6r4b1.png?width=1024&format=png&auto=webp&s=12576cea991cd7c24bd277c1c43800e81ea0e73a" # Ruta de la imagen (opcional)
    amount: 1

# Form => Keyshop
Form:
  title: "&l&9KEYSHOP"
  content: "&eSelect the key of your preference:"
# Messages
Messages:
  error:
    no-config: "&cApparently there are no keys available..."
    no-money: "&cYou don't have enough money to make this purchase!"
  success:
    successful-purchase: "&aYou have purchased &bx{AMOUNT} {KEY}&a keys for only &b{PRICE}$"
```

### 📢 Report bug
* If you find any bugs in this plugin, please let me know via: [issues](https://github.com/fernanACM/KeyShop/issues)

### 📞 Contact
| Redes | Tag | Link |
|-------|-------------|------|
| YouTube | fernanACM | [YouTube](https://www.youtube.com/channel/UC-M5iTrCItYQBg5GMuX5ySw) | 
| Discord | fernanACM#5078 | [Discord](https://discord.gg/YyE9XFckqb) |
| GitHub | fernanACM | [GitHub](https://github.com/fernanACM)
| Poggit | fernanACM | [Poggit](https://poggit.pmmp.io/ci/fernanACM)
****

### ✔ Credits
| Authors | Github | Lib |
|---------|--------|-----|
| Vecnavium | [Vecnavium](https://github.com/Vecnavium) | [FormsUI](https://github.com/Vecnavium/FormsUI/tree/master/) |
| DaPigGuy | [DaPigGuy](https://github.com/DaPigGuy) | [libPiggyEconomy](https://github.com/DaPigGuy/libPiggyEconomy) |
| DaPigGuy | [DaPigGuy](https://github.com/DaPigGuy) | [libPiggyUpdateChecker](https://github.com/DaPigGuy/libPiggyUpdateChecker) |
****

## 🔔 Icon:

The plugin icon is created via [flaticon](www.flaticon.com)
