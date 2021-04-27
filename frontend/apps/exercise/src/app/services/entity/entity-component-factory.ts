import {ComponentFactoryResolver, ComponentRef, Injectable, Type, ViewContainerRef} from "@angular/core";
import {EntityComponentMapperService} from "./entity-component-mapper.service";
import {EntityViewMode} from "../../model/entity-component/entity-view-mode";
import {EntityComponent} from "../../model/entity-component/entity-component";
import {Entity} from "../../model/entity/entity";
import {EntityType} from "../../model/entity-component/entity-type";

@Injectable()
export class EntityComponentFactory {
  public constructor(
    private readonly entityComponentMapper: EntityComponentMapperService,
    private readonly componentFactoryResolver: ComponentFactoryResolver,
  ) {}

  public fromSingle(entity: Entity, mode: EntityViewMode, viewContainerRef: ViewContainerRef): void {
    const componentType: Type<any> = this.entityComponentMapper.getComponentType(entity.type, mode);
    const componentFactory = this.componentFactoryResolver.resolveComponentFactory(componentType);
    const componentRef: ComponentRef<unknown> = viewContainerRef.createComponent(componentFactory);
    (componentRef.instance as EntityComponent).entity = entity;
  }

  public fromMultiple(entities: Entity[], mode: EntityViewMode, viewContainerRef: ViewContainerRef): void {
    entities.forEach((entity: Entity): void => {
      this.fromSingle(entity, mode, viewContainerRef);
    });
  }

  public fromType(type: EntityType, mode: EntityViewMode, viewContainerRef: ViewContainerRef): void {
    const entity: Entity = { type, id: 0, internal: false };
    this.fromSingle(entity, mode, viewContainerRef);
  }
}
