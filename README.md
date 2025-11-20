# HACKEFX Moodle
This repository contains the moodle docker setup for the Electrifex Hackefx 2.0 online coding round

## Pre-requisites:
	+ Docker must be up and running
	+ User must have sudo permissions
	+ port 80 and 443 must be exposed

## Steps to deploy:

### Step 1:
`Clone this repository`

### Step 2:
`cd hackefx-moodle \n`
`docker build -t hackefx:latest .`

### Step 3:
In docker-compose.yaml:
	+ Edit the Trafeik labels for container with your following details:
		- your website domain
		- your email
	+ Edit the moodle-hackefx container environment variables with your domain

### Step 4:
`sudo rm -rf dbdata moodledata \n`		  
`mkdir dbdata moodledata \n`
`sudo chown -R 999:999 dbdata \n`
`sudo chown -R 33:33 moodledata \n`

### Step 5:
`docker compose up -d`

### To stop:
`docker compose down`
