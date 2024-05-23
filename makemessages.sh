grep -o "translate('[^']*')" *.php | cut -d"'" -f 2 | sort | uniq | sed 's/\(.*\)/"\1","\1"/g' > translations/de.csv
