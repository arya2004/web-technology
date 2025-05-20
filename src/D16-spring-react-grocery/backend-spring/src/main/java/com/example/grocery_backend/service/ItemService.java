package com.example.grocery_backend.service;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import com.example.grocery_backend.model.Item;
import com.example.grocery_backend.repository.ItemRepository;

import java.util.List;
import java.util.Optional;

@Service
public class ItemService {

    @Autowired private ItemRepository itemRepo;

    public List<Item> listAll() {
        return itemRepo.findAll();
    }

    public Item create(Item item) {
        return itemRepo.save(item);
    }

    public Item update(Long id, Item updated) {
        Optional<Item> opt = itemRepo.findById(id);
        if (opt.isEmpty()) throw new RuntimeException("Item not found");
        Item item = opt.get();
        item.setName(updated.getName());
        item.setDescription(updated.getDescription());
        item.setPrice(updated.getPrice());
        item.setImageUrl(updated.getImageUrl());
        return itemRepo.save(item);
    }

    public void delete(Long id) {
        if (!itemRepo.existsById(id)) throw new RuntimeException("Item not found");
        itemRepo.deleteById(id);
    }
}