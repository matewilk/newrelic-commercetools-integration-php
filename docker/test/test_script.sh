#!/bin/bash

# Define an array of endpoints to call
endpoints=(
	"/products"
	"/orders"
	"/categories"
	"/inventory"
	"/non-existent-path"
)

# 2. RANDOM BURST PATTERN: Intermittent spikes in traffic to various endpoints
echo "RANDOM BURST: Starting burst pattern for various endpoints"
for i in {1..100}
do
	endpoint=${endpoints[$RANDOM % ${#endpoints[@]}]}
	echo "RANDOM BURST: Calling endpoint: $endpoint"
	curl -sS http://nginx:80$endpoint > /dev/null
	sleep 0.02  # Short sleep to intensify the burst
done

# 3. ERROR INDUCTION: Introduce calls to known bad endpoints in a controlled manner
for i in {1..7}  # Adjusted to ensure less than 7% error rate
do
	echo "ERROR INDUCTION: Calling non-existent path"
	curl -sS http://nginx:80/non-existent-path > /dev/null
	sleep 1
done

# 4. VARYING ENDPOINTS: Hit different endpoints with varying frequency
declare -A endpoint_weights=( ["/products"]=50 ["/orders"]=30 ["/categories"]=10 ["/inventory"]=10 ["/non-existent-path"]=7 )
for endpoint in "${!endpoint_weights[@]}"
do
	for i in $(seq 1 ${endpoint_weights[$endpoint]})
	do
		echo "VARYING ENDPOINTS: Calling endpoint: $endpoint"
		curl -sS http://nginx:80$endpoint > /dev/null
		sleep 0.5
	done
done

# 5. RANDOMIZED ERROR BURSTS: Occasionally hit the erroneous endpoint more frequently
if [ $((RANDOM % 4)) -eq 0 ]; then  # 25% chance of inducing an error burst
	for i in {1..30}
	do
		echo "ERROR BURST: Calling non-existent path"
		curl -sS http://nginx:80/non-existent-path > /dev/null
		sleep 0.1
	done
fi

# 6. ALTERNATING HEAVY LOAD PATTERN: Alternate heavy load between /products and other endpoints
echo "ALTERNATING HEAVY LOAD: Targeting various endpoints with high frequency"
endpoints_heavy=("/products" "/orders" "/categories" "/inventory")
for endpoint in "${endpoints_heavy[@]}"
do
	for i in {1..125}
	do
		echo "HEAVY LOAD: Targeting endpoint $endpoint"
		curl -sS http://nginx:80$endpoint > /dev/null
		sleep 0.01  # Minimal sleep to simulate heavy load
	done
done

# 7. RANDOMIZED DOWNTIME SIMULATION: Occasionally pause the script to simulate downtime
if [ $((RANDOM % 3)) -eq 0 ]; then  # 33% chance of inducing a downtime
	echo "DOWNTIME SIMULATION: Simulating a downtime for 30 seconds"
	sleep 30
fi

# Loop the entire script to keep generating traffic
exec $0
