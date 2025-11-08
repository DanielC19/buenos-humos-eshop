# Buenos Humos API Documentation

## About Buenos Humos

Buenos Humos is an e-commerce platform specializing in smoking accessories and related products. The platform offers a wide range of high-quality products across multiple categories, providing customers with a seamless shopping experience and detailed product information to help them make informed purchasing decisions.

## Products Endpoint

The Products API endpoint provides access to all products currently in stock on the Buenos Humos platform. This endpoint returns comprehensive product information including pricing, descriptions, stock levels, category details, and direct URLs to view each product on the main website. This API is designed for third-party integrations, affiliate partners, and external applications that need to display or reference Buenos Humos product catalog.

## Endpoint

### GET /api/products

Retrieve all products that have available stock.

**URL:** `{APP_URL}/api/products`

**Method:** `GET`

**Authentication:** None required

**Response Status:** `200 OK`

## JSON Response Structure

The endpoint returns a JSON object with a `data` array containing all products with available stock.

### Response Format

```json
{
  "data": [
    {
      "id": 1,
      "name": "Product Name",
      "description": "Detailed product description",
      "price": 1500,
      "sku": "PROD-001",
      "brand": "Brand Name",
      "stock": 10,
      "image": "https://example.com/storage/products/image.jpg",
      "url": "https://example.com/products/show/1",
      "category": {
        "id": 1,
        "name": "Category Name",
        "description": "Category description"
      },
    }
  ]
}
```

### Field Descriptions

| Field | Type | Description |
|-------|------|-------------|
| `id` | integer | Unique product identifier |
| `name` | string | Product name |
| `description` | string | Detailed product description |
| `price` | integer | Product price in cents (divide by 100 for decimal representation) |
| `sku` | string | Stock Keeping Unit - unique product code |
| `brand` | string | Product brand name |
| `stock` | integer | Available stock quantity |
| `image` | string\|null | URL to product image |
| `url` | string | Direct URL to view the product on Buenos Humos website |
| `category` | object | Product category information |
| `category.id` | integer | Category unique identifier |
| `category.name` | string | Category name |
| `category.description` | string\|null | Category description |
