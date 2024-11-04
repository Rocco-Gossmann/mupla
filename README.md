<!--toc:start-->
- [MuPla - Music Player](#mupla-music-player)
- [Running the Application.](#running-the-application)
  - [Requirements](#requirements)
  - [Setup](#setup)
    - [1. Clone this Repo and enter it](#1-clone-this-repo-and-enter-it)
    - [2. Configure which MP3s to play.](#2-configure-which-mp3s-to-play)
      - [2.a) by File-Copy](#2a-by-file-copy)
      - [2.b) hooking up an entire folder](#2b-hooking-up-an-entire-folder)
    - [3. (Optional) Customize the Port on which the Server will run.](#3-optional-customize-the-port-on-which-the-server-will-run)
  - [Usage](#usage)
    - [1. Start the Docker-Container via Docker-Compose](#1-start-the-docker-container-via-docker-compose)
    - [2. Open the URL in your Browser.](#2-open-the-url-in-your-browser)
    - [3. Select on of the Presented MP3 Files.](#3-select-on-of-the-presented-mp3-files)
    - [4. to stop the Server just run](#4-to-stop-the-server-just-run)
<!--toc:end-->

# MuPla - Music Player

A Docker-Application hosting a small MP3 Player, that can be accessed from your Browser.

# Running the Application.

## Requirements
-   Docker
-   Docker-Compose

## Setup

### 1. Clone this Repo and enter it

```bash
git clone github.com/rocco-gossmann/mupla
cd mupla
```

### 2. Configure which MP3s to play.

#### 2.a) by File-Copy

the easiest way to setup your MP3s is by copying them directly into the `./music` - Folder
of this Repo.

You can create as many nested folders as you like. As long as a
folder is not hidden and contains MP3s, it will be found.

#### 2.b) hooking up an entire folder

you can link existing folders to the App as well.
For that, you just need to add them to the `docker-compose.yml`s `volumes` section.

The Folder must be mounted in the `/opt/music` folder of the Container

**Syntax**: `Directory on your Computer`:`directory inside the Container`

**Example**
```yml
    volumes:
      - "./app:/var/www/html"
      - "./music:/opt/music/app"
      - "/Users/username/Music:/music/mac_Userdir "/c/users/username/Music:/music/windows_Userdir
```

### 3. (Optional) Customize the Port on which the Server will run.
By default the App will run on port 58008.
you can change that by changing the port in the `docker-compose.yml`s `ports` section.

**Syntax:** `port on your Computeer`:`port of the container` (Must always be `80`)
```yml
    ports:
      - "58008:80"
```

## Usage

### 1. Start the Docker-Container via Docker-Compose

```bash
cd /path/to/where/you/cloned/the/repo 
docker-compose up -d
```

### 2. Open the URL in your Browser.
### 3. Select on of the Presented MP3 Files.

### 4. to stop the Server just run
```bash
cd /path/to/where/you/cloned/the/repo
docker-compose down
```


