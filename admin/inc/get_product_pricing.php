<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/pricing_errors.log');

// Set JSON content type header
header('Content-Type: application/json');

// Function to send JSON error response
function sendError($message, $code = 500, $details = []) {
    http_response_code($code);
    $response = [
        'success' => false,
        'error' => $message,
        'timestamp' => date('Y-m-d H:i:s')
    ];
    if (!empty($details)) {
        $response['details'] = $details;
    }
    echo json_encode($response, JSON_PRETTY_PRINT);
    exit;
}

// Function to log errors
function logError($message, $data = null) {
    $logMessage = '[' . date('Y-m-d H:i:s') . '] ' . $message . PHP_EOL;
    if ($data !== null) {
        $logMessage .= 'Data: ' . print_r($data, true) . PHP_EOL;
    }
    error_log($logMessage, 3, __DIR__ . '/pricing_errors.log');
}

// Check if database configuration file exists
$dbConfigPath = __DIR__ . '/../../../inc/db.php';
if (!file_exists($dbConfigPath)) {
    sendError('Database configuration file not found', 500, [
        'path_checked' => $dbConfigPath,
        'current_dir' => __DIR__
    ]);
}

// Include database configuration
try {
    require_once $dbConfigPath;
    
    // Verify database connection
    if (!isset($pdo) || !($pdo instanceof PDO)) {
        sendError('Database connection failed: $pdo not initialized', 500, [
            'pdo_type' => isset($pdo) ? gettype($pdo) : 'not set'
        ]);
    }
    
    // Test the connection
    $pdo->query('SELECT 1');
    
} catch (PDOException $e) {
    sendError('Database connection failed: ' . $e->getMessage(), 500, [
        'error_code' => $e->getCode(),
        'file' => $e->getFile(),
        'line' => $e->getLine()
    ]);
} catch (Exception $e) {
    sendError('Configuration error: ' . $e->getMessage(), 500, [
        'error_type' => get_class($e)
    ]);
}

// Check for product ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    sendError('Invalid or missing product ID', 400, [
        'received_id' => $_GET['id'] ?? 'not set',
        'request_uri' => $_SERVER['REQUEST_URI'] ?? 'not available'
    ]);
}

$productId = (int)$_GET['id'];

// Log the request for debugging
logError('Product pricing request', [
    'product_id' => $productId,
    'request_time' => date('Y-m-d H:i:s'),
    'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'not set'
]);

// Validate database connection
if (!isset($pdo) || !($pdo instanceof PDO)) {
    http_response_code(500);
    die(json_encode(['success' => false, 'error' => 'Database connection failed']));
}

try {
    // Get product pricing with error handling
    try {
        $query = "SELECT id, pricing, product_name FROM products WHERE id = ?";
        logError('Executing query', ['query' => $query, 'product_id' => $productId]);
        
        $stmt = $pdo->prepare($query);
        if ($stmt === false) {
            throw new PDOException('Failed to prepare query: ' . implode(', ', $pdo->errorInfo()));
        }
        
        $executed = $stmt->execute([$productId]);
        if ($executed === false) {
            throw new PDOException('Failed to execute query: ' . implode(', ', $stmt->errorInfo()));
        }
        
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$product) {
            sendError('Product not found', 404, [
                'product_id' => $productId,
                'query' => $query
            ]);
        }
        
        logError('Product found', [
            'product_id' => $productId,
            'has_pricing' => !empty($product['pricing'])
        ]);
        
    } catch (PDOException $e) {
        logError('Database query failed', [
            'error' => $e->getMessage(),
            'query' => $query ?? 'not set',
            'product_id' => $productId,
            'trace' => $e->getTraceAsString()
        ]);
        sendError('Database query failed: ' . $e->getMessage(), 500, [
            'error_code' => $e->getCode(),
            'query' => $query ?? 'not set'
        ]);
    }
    
    // Initialize default pricing structure
    $defaultPricing = [
        'size' => null,
        'sn_price' => '0.00',
        'bk_price' => '0.00',
        'an_price' => '0.00',
        'gd_price' => '0.00',
        'rg_price' => '0.00',
        'ch_price' => '0.00',
        'gl_price' => '0.00'
    ];
    
    // Initialize response
    $response = [
        'success' => true,
        'product_id' => $productId,
        'product_name' => $product['product_name']
    ];
    
    // Check if pricing data exists
    try {
        logError('Processing pricing data', [
            'product_id' => $productId,
            'raw_pricing' => $product['pricing'],
            'pricing_type' => gettype($product['pricing'])
        ]);
        
        if (empty($product['pricing'])) {
            // No pricing data, return default
            logError('No pricing data found, using defaults', ['product_id' => $productId]);
            $response['pricing'] = [$defaultPricing];
            $response['message'] = 'Using default pricing (no pricing data found)';
        } else {
            // Try to decode the pricing JSON
            $pricing = json_decode($product['pricing'], true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                // Log JSON decode error
                $jsonError = json_last_error_msg();
                logError('JSON decode error', [
                    'product_id' => $productId,
                    'error' => $jsonError,
                    'json_error_code' => json_last_error(),
                    'raw_pricing' => $product['pricing']
                ]);
                
                $response['pricing'] = [$defaultPricing];
                $response['message'] = 'Using default pricing (invalid pricing data)';
                $response['warning'] = 'Pricing data is not valid JSON: ' . $jsonError;
            } elseif (empty($pricing) || !is_array($pricing)) {
                // If pricing is empty or not an array, use default
                logError('Empty or invalid pricing array', [
                    'product_id' => $productId,
                    'pricing_type' => gettype($pricing),
                    'pricing_count' => is_array($pricing) ? count($pricing) : 'N/A'
                ]);
                
                $response['pricing'] = [$defaultPricing];
                $response['message'] = 'Using default pricing (no valid pricing entries)';
            } else {
                // Process valid pricing data
                logError('Processing pricing entries', [
                    'product_id' => $productId,
                    'entry_count' => count($pricing)
                ]);
                
                $formattedPricing = [];
                $entryCount = 0;
                
                foreach ($pricing as $index => $item) {
                    $entryCount++;
                    
                    if (!is_array($item)) {
                        logError('Skipping invalid pricing entry', [
                            'product_id' => $productId,
                            'entry_index' => $index,
                            'entry_type' => gettype($item),
                            'entry_value' => $item
                        ]);
                        continue; // Skip invalid entries
                    }
                    
                    $formattedItem = $defaultPricing; // Start with defaults
                    
                    try {
                        // Only override with valid values
                        if (isset($item['size'])) {
                            $formattedItem['size'] = is_string($item['size']) ? trim($item['size']) : (string)$item['size'];
                        }
                        
                        // Format each price field
                        $priceFields = ['sn_price', 'bk_price', 'an_price', 'gd_price', 'rg_price', 'ch_price', 'gl_price'];
                        foreach ($priceFields as $field) {
                            if (array_key_exists($field, $item)) {
                                $value = $item[$field];
                                if (is_numeric($value) || $value === '') {
                                    $formattedItem[$field] = $value === '' ? '0.00' : number_format((float)$value, 2, '.', '');
                                }
                            }
                        }
                        
                        $formattedPricing[] = $formattedItem;
                        
                    } catch (Exception $e) {
                        logError('Error processing pricing entry', [
                            'product_id' => $productId,
                            'entry_index' => $index,
                            'error' => $e->getMessage(),
                            'trace' => $e->getTraceAsString()
                        ]);
                        // Continue with next entry even if one fails
                    }
                }
                
                logError('Finished processing pricing entries', [
                    'product_id' => $productId,
                    'total_entries' => count($pricing),
                    'valid_entries' => count($formattedPricing)
                ]);
                
                // If no valid pricing entries were found, use default
                if (empty($formattedPricing)) {
                    logError('No valid pricing entries found, using defaults', ['product_id' => $productId]);
                    $response['pricing'] = [$defaultPricing];
                    $response['message'] = 'Using default pricing (no valid pricing entries found)';
                } else {
                    $response['pricing'] = $formattedPricing;
                    $response['message'] = 'Successfully loaded ' . count($formattedPricing) . ' pricing entries';
                }
            }
        }
    } catch (Exception $e) {
        logError('Error processing pricing data', [
            'product_id' => $productId,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        
        // Fall back to default pricing on any error
        $response['pricing'] = [$defaultPricing];
        $response['message'] = 'Using default pricing (error processing pricing data)';
        $response['error'] = $e->getMessage();
    }
    
    // Output the response
    echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    
} catch (PDOException $e) {
    $errorMessage = 'Database error: ' . $e->getMessage();
    error_log($errorMessage);
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Database error occurred',
        'message' => $errorMessage
    ]);
} catch (Exception $e) {
    $errorMessage = 'Unexpected error: ' . $e->getMessage();
    error_log($errorMessage);
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'An unexpected error occurred',
        'message' => $errorMessage
    ]);
}
