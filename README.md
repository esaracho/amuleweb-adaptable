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

![login](https://github.com/esaracho/amuleweb-adaptable/assets/17080020/f2731ccc-9456-4ca0-91e3-08a8e8c35025)

![menu](https://github.com/esaracho/amuleweb-adaptable/assets/17080020/8f7c2865-2984-49b6-be64-05bab9b325c8)

![transfer](https://github.com/esaracho/amuleweb-adaptable/assets/17080020/1a85c07b-49f4-4461-bb06-20cb4653c5d6)

![shared](https://github.com/esaracho/amuleweb-adaptable/assets/17080020/74782916-1a01-453f-b7f1-04ee93342681)

![search](https://github.com/esaracho/amuleweb-adaptable/assets/17080020/bf3982c8-2869-4d41-8ae0-da8ab675fd5f)

![servers](https://github.com/esaracho/amuleweb-adaptable/assets/17080020/55fab139-c65e-476a-9b2d-09d094d88244)

![settings](https://github.com/esaracho/amuleweb-adaptable/assets/17080020/f11a2047-92a4-4622-b5bb-87f99e5a3f01)

![log](https://github.com/esaracho/amuleweb-adaptable/assets/17080020/3f306c76-fa11-45d2-b70a-0c648f415546)


## Desktop

![login](https://github.com/esaracho/amuleweb-adaptable/assets/17080020/d8eca23f-d2b7-43d4-942c-ca6921f8498e)

![transfer](https://github.com/esaracho/amuleweb-adaptable/assets/17080020/d9a49f3a-8108-4420-aca2-c691fd9702fd)

![shared](https://github.com/esaracho/amuleweb-adaptable/assets/17080020/39cfa28e-1581-4fdd-a6c6-05463782b2b5)

![search](https://github.com/esaracho/amuleweb-adaptable/assets/17080020/ab5de585-eda4-4cf1-b356-71d286f2c720)

![servers](https://github.com/esaracho/amuleweb-adaptable/assets/17080020/fa20b8da-cfff-43a5-bb7b-3597bc1ff40a)

![settings](https://github.com/esaracho/amuleweb-adaptable/assets/17080020/748f473a-d154-45c6-b04c-d89a52e6dacf)

![logs](https://github.com/esaracho/amuleweb-adaptable/assets/17080020/93337d2d-3861-4278-bfbd-36861a15501e)





