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

Edit line `Template` in configuration file /home/your-user/.aMule/amule.conf:

```
Template=amuleweb-adaptable
```

Start `amule-daemon` service:

```
sudo systemctl start amule-daemon.service
```

# Screenshots

## Mobile

![login](https://github.com/esaracho/amuleweb-adaptable/assets/17080020/bd13396d-8105-4705-88fa-52f9f46d7c4a) 

![menu](https://github.com/esaracho/amuleweb-adaptable/assets/17080020/0645f388-1f1d-462d-b92f-9853f0486a4e)

![transfer](https://github.com/esaracho/amuleweb-adaptable/assets/17080020/f69ed9c6-bf2a-4e38-88e1-963c55b4a56b)

![shared](https://github.com/esaracho/amuleweb-adaptable/assets/17080020/ee269c1a-6c54-4be7-ae67-ffe1c389e561)

![search](https://github.com/esaracho/amuleweb-adaptable/assets/17080020/4249f81c-53a4-45a9-a144-9b07a9dff689)

![servers](https://github.com/esaracho/amuleweb-adaptable/assets/17080020/117b8547-6044-4df9-a295-29c849612dce)

![settings](https://github.com/esaracho/amuleweb-adaptable/assets/17080020/afa3dfaa-0ad6-42b9-bee0-c5cce264c8da)

![log](https://github.com/esaracho/amuleweb-adaptable/assets/17080020/fc4cb117-b373-490e-b33a-3aa269f73810)

## Desktop

![login](https://github.com/esaracho/amuleweb-adaptable/assets/17080020/d8eca23f-d2b7-43d4-942c-ca6921f8498e)

![transfer](https://github.com/esaracho/amuleweb-adaptable/assets/17080020/d9a49f3a-8108-4420-aca2-c691fd9702fd)

![shared](https://github.com/esaracho/amuleweb-adaptable/assets/17080020/39cfa28e-1581-4fdd-a6c6-05463782b2b5)

![search](https://github.com/esaracho/amuleweb-adaptable/assets/17080020/ab5de585-eda4-4cf1-b356-71d286f2c720)

![servers](https://github.com/esaracho/amuleweb-adaptable/assets/17080020/fa20b8da-cfff-43a5-bb7b-3597bc1ff40a)

![settings](https://github.com/esaracho/amuleweb-adaptable/assets/17080020/748f473a-d154-45c6-b04c-d89a52e6dacf)

![logs](https://github.com/esaracho/amuleweb-adaptable/assets/17080020/93337d2d-3861-4278-bfbd-36861a15501e)





