sudo iptables -t nat -A POSTROUTING -o eth0 -j MASQUERADE
    sudo iptables -t nat -I PREROUTING -p tcp --dport 80  -j DNAT --to-destination 1.1.1.1
    sudo iptables -t nat -I PREROUTING -p tcp --dport 443  -j DNAT --to-destination 1.1.1.1
