status="$(curl -Is https://forge.laravel.com/servers/441730/sites/1271661/deploy/http?token=2KNY8h9b1qyHatV1KNqBGwEv2ecW38FuO14svZg5 | head -1)"
validate=( $status )
if [ ${validate[-2]} == "200" ]; then
  echo "OK"
else
  echo "NOT RESPONDING"
fi