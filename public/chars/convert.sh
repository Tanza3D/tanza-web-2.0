#!/bin/bash

DIR="${1:-.}"

find "$DIR" -type f -iname "*.png" -print0 | while IFS= read -r -d '' file; do
    output="${file%.*}.webp"
    
    if [[ -f "$output" ]]; then
        echo "SKIP: $output exists"
        continue
    fi
    
    if command -v cwebp &> /dev/null; then
        cwebp -q 85 "$file" -o "$output" -quiet
    else
        ffmpeg -i "$file" -quality 85 "$output" -loglevel error -y
    fi
    
    echo "DONE: $file -> $output"
done

echo "Finished."
