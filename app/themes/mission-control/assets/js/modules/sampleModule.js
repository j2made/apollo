// Export a message
export const sampleMessage = () => 'This is the sampleMessage const from sampleModule.js';

// Export a basic addition function
export function sampleAddModule(a, b = 2) {
  let val = a + b;
  return `The value of the sampleAddModule() is ${val}`;
}