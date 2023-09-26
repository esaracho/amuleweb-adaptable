# amuleweb-adaptable
A resposive web UI for Amule.

Based on the work of [default web interface](https://github.com/amule-project/amule/tree/master/src/webserver/default) and [AmuleWebUI-Reloaded](https://github.com/MatteoRagni/AmuleWebUI-Reloaded)

# Installation

Stop `amule-daemon` service:
```
sudo systemctl stop amule-daemon.service
```

Clone an copy directory:

```
git clone https://github.com/esaracho/amuleweb-adaptable.git
```
```
sudo cp -r amuleweb-adaptable /usr/share/amule/webserver
```

Edit line `Template` in configuration file .aMule/amule.conf:

```
Template=amuleweb-adaptable
```

Start `amule-daemon` service:

```
sudo systemctl start amule-daemon.service
```


