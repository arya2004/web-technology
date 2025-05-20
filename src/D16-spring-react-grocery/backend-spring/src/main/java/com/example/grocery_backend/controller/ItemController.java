package com.example.grocery_backend.controller;

import com.example.grocery_backend.model.Item;
import com.example.grocery_backend.service.ItemService;
import lombok.AllArgsConstructor;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@RequestMapping("/api/items")
@AllArgsConstructor
public class ItemController {

    private final ItemService itemService;

    @GetMapping
    public ResponseEntity<List<Item>> listAll() {
        return ResponseEntity.ok(itemService.listAll());
    }

    @PostMapping
    public ResponseEntity<Item> create(@RequestBody Item item) {
        Item created = itemService.create(item);
        return ResponseEntity.status(201).body(created);
    }

    @PutMapping("/{id}")
    public ResponseEntity<Item> update(
        @PathVariable Long id, @RequestBody Item item) {
        return ResponseEntity.ok(itemService.update(id, item));
    }

    @DeleteMapping("/{id}")
    public ResponseEntity<Void> delete(@PathVariable Long id) {
        itemService.delete(id);
        return ResponseEntity.noContent().build();
    }
}