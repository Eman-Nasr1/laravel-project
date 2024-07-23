<?php  

namespace Tests\Unit;  

use App\Models\Product;  
use App\Models\User; // Make sure to include the User model  
use Illuminate\Foundation\Testing\RefreshDatabase;  
use Tests\TestCase;  

class ProductControllerTest extends TestCase  
{  
    use RefreshDatabase;  

    public function test_create_product()  
    {  
        // Create a user for authentication  
        $user = User::factory()->create(); // Create a user using factories  

        // Prepare product data  
        $productData = [  
            'name' => 'Test Product',  
            'quantity' => 4,  
            'price' => 99.99,  
        ];  

        // Authenticate the user  
        $response = $this->actingAs($user, 'sanctum')  
                         ->post('/api/products', $productData);  

        // Assert the response and database entry  
        $response->assertStatus(201);  
        $this->assertDatabaseHas('products', $productData);  
    }  
}