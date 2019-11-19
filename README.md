## Function

Telegram message notifications for miners.
## Installation
Step 1:  Create a bot and get the code
```
https://www.teleme.io/articles/create_your_own_telegram_bot?hl=vi
```
Step 2: Edit token - Token obtained from step 1

```
define('token', '461268828:AAGhAxduZtKmyzpzgOLK-0ftuYvZzTOXecA');<= Change your token
```

```bash
$content_json->data[4024]->time; <= Change 4024
```

optionally according to your server port pool

```
asia1:4024|eu1:4025|us1:4026|us2:4027
```


## Usage

```
checkMiner($Severpool['zcash'], $Ethermine_wallet['Vi001'], $telegram_id['HideX']);
```
```bash
$Severpool['zcash'] => Type of coin zcash || ethermine
```
```bash
$Ethermine_wallet['Vi001'] => The Wallet txt 
```
```
$telegram_id['HideX'] => Recipient ID, can group
```

Note: 
You cannot force hard on the function, please edit behind define ('token') in the index.php file


```
Code by Sodachi
```
