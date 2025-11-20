# HACKEFX Moodle

This repository contains the Moodle Docker setup for the Electrifex Hackefx 2.0 online coding round.

## Pre-requisites:
- Docker must be up and running
- User must have sudo permissions
- Port 80 and 443 must be exposed

## Steps to Deploy:

### Step 1:
Clone this repository:
```bash
git clone <repository-url>
```

### Step 2:
Build the Docker image:
```bash
cd hackefx-moodle
docker build -t hackefx:latest .
```

### Step 3:
In `docker-compose.yaml`:
- Edit the Traefik labels for the container with your details:
  - Your website domain
  - Your email
- Edit the `moodle-hackefx` container environment variables with your domain

### Step 4:
Set up data directories:
```bash
sudo rm -rf dbdata moodledata
mkdir dbdata moodledata
sudo chown -R 999:999 dbdata
sudo chown -R 33:33 moodledata
```

### Step 5:
Start the containers:
```bash
docker compose up -d
```

## To Stop:
```bash
docker compose down
```

The formatting is now clean and consistent with proper markdown syntax, code blocks, and organized structure.
