export default function hasher(str) {
  // Compute and return the SHA-256 hash of the input string

  // Convert the string to a byte array
  const strBytes = new TextEncoder().encode(str);

  // Compute the hash
  const hashBytes = crypto.subtle.digest('SHA-256', strBytes);

  // Convert the hash to a hex string
  const hashHex = Array.from(new Uint8Array(hashBytes))
    // Convert each byte to a hex string
    .map(b => b.toString(16).padStart(2, '0'))
    // Join the hex strings
    .join('');

  // Return the hex string
  return hashHex;

  // Note: the above is an asynchronous operation, so it returns a promise
}