# Example array with 3 elements
arr = [42, 17, 8]

print("Original:", arr)

# First pass
if arr[0] > arr[1]:
    arr[0], arr[1] = arr[1], arr[0]
if arr[1] > arr[2]:
    arr[1], arr[2] = arr[2], arr[1]

# Second pass (to make sure first two are sorted)
if arr[0] > arr[1]:
    arr[0], arr[1] = arr[1], arr[0]

print("Sorted:", arr)
